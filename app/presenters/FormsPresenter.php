<?php
namespace App\Presenters;

use App\Components\IHealthDeclarationFactory;
use App\Model\HealthDeclaration;
use Nette\Application\BadRequestException;
use Nette\Utils\Strings;
use PdfResponse\PdfResponse;

class FormsPresenter extends BasePresenter
{
	/** @var HealthDeclaration */
	private $healthDeclaration;
	/** @var IHealthDeclarationFactory */
	private $healthDeclarationFactory;

	public function injectForms(HealthDeclaration $healthDeclaration, IHealthDeclarationFactory $healthDeclarationFactory)
	{
		$this->healthDeclaration = $healthDeclaration;
		$this->healthDeclarationFactory = $healthDeclarationFactory;
	}

	public function renderHealthDeclaration() {}

	public function renderFilledForm($email, $code)
	{
		$hd = $this->healthDeclaration;
		$values = $hd->findByEmail($email)->fetchAll();
		$values = $values[0];
		if ($code != $values["code"]) {
			throw new BadRequestException('Wrong code', 404);
		}
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . "/../templates/filledForm.latte");
		$template->v = $values;
		$pdf = new PDFResponse($template);
		$pdf->outputName = Strings::webalize($values["name"]) . ".pdf";
		$pdf->outputDestination = PDFResponse::OUTPUT_INLINE;
		$this->sendResponse($pdf);
		$this->terminate();
	}

	public function createComponentHealthDeclaration()
	{
		return $this->healthDeclarationFactory->create();
	}

}
