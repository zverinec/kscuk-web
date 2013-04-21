<?php
class DefaultPresenter extends BasePresenter
{

	public function beforeRender() {
	}

	public function renderDefault() {}

	public function renderRegistration() {}

	public function createComponentRegistration($name) {
		return new RegistrationComponent($this, $name);
	}

}
