<?php
class BasePresenter extends Presenter {

	private $questions;

	private $people;

	protected function startUp() {
		parent::startup();
	}

	protected function createTemplate() {
		$template = parent::createTemplate();

		$this->oldLayoutMode = false;

		$user = Environment::getUser();
		if ($user->isLoggedIn()) {
			$template->logged = TRUE;
		}
		else {
			$template->logged = FALSE;
		}
		$template->registerFilter(new LatteFilter());
		$template->registerHelper('texy', Helpers::getHelper('texy'));
		return $template;
	}

	/** @return Question */
	protected final function getQuestions() {
		if (!isset($this->questions)) {
			$this->questions = new Question();
		}
		return $this->questions;
	}

	/** @return Person */
	protected final function getPeople() {
		if (!isset($this->people)) {
			$this->people = new Person();
		}
		return $this->people;
	}

}
