<?php
abstract class BaseComponent extends Control {
	
	private $questions;

	private $people;
	
	private $hd;

	public function  __construct(IComponentContainer $parent = NULL, $name = NULL) {
		parent::__construct($parent, $name);
		$this->startUp();
	}

	protected function beforeRender() {}

	protected function startUp() {}

	public function render() {
		$this->beforeRender();
		return $this->getTemplate()->render();
	}

	protected function createTemplate() {
		$template = new Template();
		$name = strtr($this->getReflection()->getName(), array("Component" => ""));
		$componentName = substr_replace($name, strtolower(substr($name, 0, 1)), 0, 1);

		$template->setFile(dirname(__FILE__) . '/' . $componentName . '/' . $componentName . ".phtml");

		$template->registerFilter(new LatteFilter());
		$template->registerHelper('texy', Helpers::getHelper('texy'));
		$template->control = $this;
		$template->presenter = $this->getPresenter();

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
	
	/** @return HealthDeclaration */
	protected final function getHealthDeclaration() {
		if (!isset($this->hd)) {
			$this->hd = new HealthDeclaration();
		}
		return $this->hd;
	}
		
}