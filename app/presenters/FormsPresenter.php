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
		$values = $this->getHealthDeclaration($email);
		$foodProblems = $this->getFoodProblems($email);
		if ($code != $values["code"]) {
			throw new BadRequestException('Wrong code', 404);
		}
		$this->sendAsPDF($values, $foodProblems);
	}

	public function renderFilledFormOrg($email)
	{
		if (!$this->user->isLoggedIn()) {
			$this->flashMessage("Neoprávněný přístup do organizátorské sekce!", "error");
			$this->redirect("Org:auth");
		}
		$values = $this->getHealthDeclaration($email);
		$foodProblems = $this->getFoodProblems($email);
		$this->sendAsPDF($values, $foodProblems);
	}

	public function createComponentHealthDeclaration()
	{
		return $this->healthDeclarationFactory->create();
	}

	private function getHealthDeclaration($email) {
		$hd = $this->healthDeclaration;
		$values = $hd->findByEmail($email)->fetchAll();
		return $values[0];
	}

	private function getFoodProblems($email) {
		$answers= $this->person->findByEmail($email);
		return $answers["Máš nějaká stravovací omezení?"]; // Question name may change!
	}

	private function sendAsPDF($values, $foodProblems) {
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . "/../templates/filledForm.latte");
		$template->v = $values;
		$template->foodProblems = $foodProblems;

		$pdf = new PDFResponse($template);
		$pdf->outputName = Strings::webalize($values["name"]) . ".pdf";
		$pdf->outputDestination = PDFResponse::OUTPUT_INLINE;
		$this->sendResponse($pdf);
		$this->terminate();
	}
}
