<?php
namespace App\Presenters;

use App\Components\IRegistrationFactory;

class DefaultPresenter extends BasePresenter
{
	/** @var IRegistrationFactory */
	private $registrationFactory;

	public function injectDefault(IRegistrationFactory $registrationFactory)
	{
		$this->registrationFactory = $registrationFactory;
	}

	public function renderDefault() {}

	public function renderArchiv() {}

	public function renderRegistration() {}

	public function createComponentRegistration()
	{
		return $this->registrationFactory->create();
	}

}
