<?php
namespace App\Presenters;

use Alchemy\Zippy\Zippy;
use App\Components\IAuthFormFactory;
use App\Components\IPeopleFactory;
use App\Model\Import;
use Dibi\Connection;
use MySQLDump;
use mysqli;
use Nette\Application\Responses\FileResponse;
use PharData;

class OrgPresenter extends BasePresenter
{

	/** @var Import */
	private $import;
	/** @var IAuthFormFactory */
	private $authFormFactory;
	/** @var IPeopleFactory */
	private $peopleFactory;
	/** @var Dibi\Connection */
	private $connection;

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
		$destination = __DIR__  . '/../../temp/health_declaration.tar';
		$input = __DIR__ . '/../../www/storage/health_declaration';
		$zippy = Zippy::load();
		$archive = $zippy->create($destination, array(
			'folder' => $input
		));
		$this->sendResponse(new FileResponse($destination));
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
