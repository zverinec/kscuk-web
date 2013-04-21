<?php
class AuthForm extends BaseComponent
{

	private $destination;

	public function render() {
		$this->getTemplate()->form = $this->getComponent('form');
		return parent::render();

	}

	public function formSubmitted(Form $form) {
		if (!isset($this->destination)) {
			throw new InvalidStateException("The destination is not set.");
		}
		try {
			Environment::getUser()->login(NULL, $form['password']->getValue());
			$this->getPresenter()->redirect($this->destination);
		}
		catch(AuthenticationException $e) {
			$this->getPresenter()->flashMessage('Přihlášení se nezdařilo!', 'error');
			$this->getPresenter()->redirect('this');
		}
	}

	public function setRedirect($destination) {
		$this->destination = $destination;
	}

	public function createComponentForm($name) {
		$form = new AppForm($this, $name);

		$form->addPassword('password', 'Heslo:');
		$form->addSubmit('login', 'Přihlásit se');
		$form->onSubmit[] = array($this, 'formSubmitted');

		return $form;
	}
 
}
