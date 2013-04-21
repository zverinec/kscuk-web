<?php
class FormsPresenter extends BasePresenter
{

	public function renderHealthDeclaration() {}
	
	public function renderFilledForm($email,$code) {
		$hd = new HealthDeclaration();
		$values = $hd->findByEmail($email)->fetchAll();
		$values = $values[0];
		if($code != $values["code"]) {
			throw new BadSignalException();
		}
		$template = new Template();
		$template->setFile(APP_DIR."/templates/filledForm.phtml");
		$template->registerFilter(new LatteFilter());
		$template->registerHelper('escapeUrl', 'rawurlencode');
		$template->registerHelper('stripTags', 'strip_tags');
		$template->registerHelper('nl2br', 'nl2br');
		$template->registerHelperLoader('Nette\Templates\TemplateHelpers::loader');
		$template->v = $values;
		$pdf = new PDFResponse($template);
		$pdf->outputName = String::webalize($values["name"]).".pdf";
		$pdf->outputDestination = PDFResponse::OUTPUT_INLINE;
		$pdf->send();
		$this->terminate();
	}

	public function createComponentHealthDeclaration($name) {
		return new HealthDeclarationComponent($this, $name);
	}

}
