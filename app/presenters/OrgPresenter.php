<?php
class OrgPresenter extends BasePresenter
{

	protected function startUp() {
		parent::startUp();
		if (!Environment::getUser()->isLoggedIn()) {
			if ($this->getAction() != 'auth') {
				$this->flashMessage("Neoprávnění přístup do organizátorské sekce!", "error");
				$this->redirect("auth");
			}
		}
	}

	public function actionLogout() {
		Environment::getUser()->logout(true);
		$this->getPresenter()->redirect('this');
	}

	public function actionReset() {
		$config = Environment::getConfig('registration');
		if(!$config->deletable) {
			$this->flashMessage('Databázi nelze vymazat.', 'error');
			$this->redirect('default');
			return;
		}
		$import = new Import();
		$import->clearDatabase();
		$this->flashMessage("Databáze byla restartována.", "success");
		$this->redirect("default");
	}

	public function renderAuth() {
	}

	public function renderDefault() {
		
	}

	public function renderDetail($person) {
		if (empty($person)) {
			$this->flashMessage('Nebylo zadáno ID účastníka, na kterého se chceš podívat.', 'error');
			$this->redirect('default');
		}
		Tools::tryError();
		$files = glob(WWW_DIR . '/storage/people/' . $person . '.*');
		if (Tools::catchError($msg)) {
			$this->flashMessage('Stala se neočekávaná chyba při nahrávání obrázku.', 'error');
		}
		if (!empty($files)) {
			$this->getTemplate()->image = strtr($files[0], array(WWW_DIR . '/' => ''));
		}
		else {
			$this->flashMessage('Obrázek účastníka není k dispozici.', 'error');
		}
		$this->getTemplate()->questions		= $this->getQuestions()->findAll()->fetchAssoc('category,id_question');
		$this->getTemplate()->people		= $this->getPeople()->findAnswers($person, NULL)->fetchAssoc('id_question');
		$this->getTemplate()->categories	= array(
			'personal'		=> 'Personálie',
			'interesting'	=> 'Zvídavé otázky',
			'organization'	=> 'Organizační záležitosti'
		);
	}

	public function createComponentAuthForm($name) {
		$form = new AuthForm($this, $name);
		$form->setRedirect('Org:default');
		return $form;
	}

	public function createComponentPeople($name) {
		return new PeopleComponent($this, $name);
	}
}
