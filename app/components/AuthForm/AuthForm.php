<?php
namespace App\Components;

use Nette\Application\UI\Form;
use Nette\InvalidStateException;
use Nette\Security\AuthenticationException;
use Nette\Security\User;

class AuthForm extends BaseComponent
{
	/** @var User */
	private $user;

	private $destination;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function formSubmitted(Form $form)
	{
		if (!isset($this->destination)) {
			throw new InvalidStateException("The destination is not set.");
		}
		try {
			$this->user->login(NULL, $form['password']->getValue());
			$this->getPresenter()->redirect($this->destination);
		} catch (AuthenticationException $e) {
			$this->getPresenter()->flashMessage('Přihlášení se nezdařilo!', 'error');
			$this->getPresenter()->redirect('this');
		}
	}

	public function setRedirect($destination)
	{
		$this->destination = $destination;
	}

	public function createComponentForm($name)
	{
		$form = new Form($this, $name);

		$form->addPassword('password', 'Heslo:');
		$form->addSubmit('login', 'Přihlásit se')->setHtmlAttribute('class', 'orange');
		$form->onSuccess[] = [$this, 'formSubmitted'];

		return $form;
	}

}
