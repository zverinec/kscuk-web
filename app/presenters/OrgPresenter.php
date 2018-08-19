<?php
namespace App\Presenters;

use App\Components\IAuthFormFactory;
use App\Components\IPeopleFactory;
use App\Model\Import;
use Dibi;
use MySQLDump;
use mysqli;
use PharData;
use App\Components\IHealthDeclarationFactory;
use App\Model\HealthDeclaration;
use PdfResponse\PdfResponse;
use Mpdf\Output\Destination;
use ZipStream\ZipStream;
use Nette\Utils\Strings;

class OrgPresenter extends BasePresenter
{

	/** @var Import */
	private $import;
	/** @var IAuthFormFactory */
	private $authFormFactory;
	/** @var HealthDeclaration */
	private $healthDeclaration;
	/** @var IHealthDeclarationFactory */
	private $healthDeclarationFactory;
	/** @var IPeopleFactory */
	private $peopleFactory;
	/** @var Dibi\Connection */
	private $connection;

	public function injectForms(HealthDeclaration $healthDeclaration, IHealthDeclarationFactory $healthDeclarationFactory)
	{
		$this->healthDeclaration = $healthDeclaration;
		$this->healthDeclarationFactory = $healthDeclarationFactory;
	}

	public function injectOrg(Import $import, IAuthFormFactory $authFormFactory, IPeopleFactory $peopleFactory, \Dibi\Connection $connection)
	{
		$this->import = $import;
		$this->authFormFactory = $authFormFactory;
		$this->peopleFactory = $peopleFactory;
		$this->connection = $connection;
	}

	protected function startUp()
	{
		parent::startUp();
		if (!$this->user->isLoggedIn()) {
			if ($this->getAction() != 'auth') {
				$this->flashMessage("Neoprávněný přístup do organizátorské sekce!", "error");
				$this->redirect("auth");
			}
		}
	}

	public function actionLogout()
	{
		$this->user->logout(true);
		$this->getPresenter()->redirect('this');
	}

	public function actionReset()
	{
		$config = $this->parameters->getRegistration();
		if (!$config->deletable) {
			$this->flashMessage('Databázi nelze vymazat.', 'error');
			$this->redirect('default');
			return;
		}
		$this->import->clearDatabase();
		$this->flashMessage("Databáze byla restartována.", "success");
		$this->redirect("default");
	}

	public function actionDump()
	{
		$connection = $this->connection;

		$dump = new MySQLDump(new mysqli($connection->getConfig('host'), $connection->getConfig('username'), $connection->getConfig('password'), $connection->getConfig('database')));
		$dump->tables['search_cache'] = MySQLDump::DROP | MySQLDump::CREATE;
		$dump->tables['log'] = MySQLDump::NONE;
		$name = 'kscuk_' . date('Y-m-d-H-i') . '.sql';
		$this->getHttpResponse()->setContentType('application/octet-stream');
		$this->getHttpResponse()->setHeader('Content-Disposition', 'attachment; filename="' . $name . '"');
		$dump->write();
		$this->terminate();
	}

	public function actionDownload()
	{
		$hd = $this->healthDeclaration;
		$declarations = $hd->getAll()->fetchAll();

		$zip = new ZipStream('health_declarations.zip', array(ZipStream::OPTION_SEND_HTTP_HEADERS => true));

		foreach ($declarations as $d) {
			$template = $this->createTemplate();
			$template->setFile(__DIR__ . "/../templates/filledForm.latte");
			$template->v = $d;
			$pdf = new PDFResponse($template);
			$pdf->outputName = Strings::webalize($d["name"]) . ".pdf";
			$pdf->outputDestination = PDFResponse::OUTPUT_STRING;

			// $pdf->send generates the pdf content, but when not really sent, discards the return string content...
			$pdf->send($this->getHttpRequest(), $this->getHttpResponse());

			// so the string content has to be collected again, directly through mpdf
			$fp = fopen('php://memory','r+');
			fwrite($fp, $pdf->getMPDF()->Output('',Destination::STRING_RETURN));
			rewind($fp);
			$zip->addFileFromStream(Strings::webalize($d["name"]) . ".pdf", $fp);
			fclose($fp);
		}
		$zip->finish();

		readfile("php://output");
		$this->terminate();
	}

	public function renderAuth() {}

	public function renderDefault() {}

	public function renderDetail($person)
	{
		if (empty($person)) {
			$this->flashMessage('Nebylo zadáno ID účastníka, na kterého se chceš podívat.', 'error');
			$this->redirect('default');
		}
		$files = glob(__DIR__ . '/../../www/storage/people/' . $person . '.*');
		if (!empty($files)) {
			$this->getTemplate()->image = strtr($files[0], array(__DIR__ . '/../../www' => ''));
		} else {
			$this->flashMessage('Obrázek účastníka není k dispozici.', 'error');
		}
		$this->getTemplate()->questions = $this->question->findAll()->fetchAssoc('category,id_question');
		$this->getTemplate()->people = $this->person->findAnswers($person, NULL)->fetchAssoc('id_question');
		$this->getTemplate()->categories = array(
			'personal' => 'Personálie',
			'interesting' => 'Zvídavé otázky',
			'organization' => 'Organizační záležitosti'
		);

		$email = $this->person->findEmailById($person);
		$hd = $this->healthDeclaration->findByEmail($email);
		$this->getTemplate()->healthDeclarationFilled = count($hd) > 0 ? true : false;
		$this->getTemplate()->email = $email;
	}

	public function createComponentAuthForm()
	{
		$form = $this->authFormFactory->create();
		$form->setRedirect('Org:default');
		return $form;
	}

	public function createComponentPeople()
	{
		return $this->peopleFactory->create();
	}
}
