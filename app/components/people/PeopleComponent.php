<?php
class PeopleComponent extends BaseComponent
{


	/** @persistent */
	public $questions;

	/** @persistent */
	public $printable;

	public function questionFormSubmitted(Form $form) {
		$this->questions = array();
		$values = $form->getValues();
		foreach($this->getQuestions()->findAll() AS $question) {
			if ($values['question' . $question->id_question]) {
				$this->questions[] = $question->id_question;
			}
		}
		$this->setPrintable();
		$this->getPresenter()->redirect('this');
	}

	public function setPrintable($printable = TRUE) {
		$this->printable = $printable;
	}

	protected function beforeRender() {
		if (empty($this->questions)) {
			$this->getTemplate()->questions		= $this->getQuestions()->findAll('personal')->fetchAssoc('id_question');
			$this->getTemplate()->people		= $this->getPeople()->findAnswers(NULL, 'personal')->orderBy('id_registered', 'DESC')->fetchAssoc('id_registered,id_question');
		}
		else {
			$this->getTemplate()->questions		= $this->getQuestions()->findAll()->where('id_question IN %l', $this->questions)->fetchAssoc('id_question');
			$this->getTemplate()->people		= $this->getPeople()->findAnswers(NULL, NULL)->where('id_question IN %l', $this->questions)->orderBy('id_registered', 'DESC')->fetchAssoc('id_registered,id_question');
		}
		$this->getTemplate()->printable = $this->printable;
	}

	public function createComponentQuestionForm($name) {
		$form = new AppForm($this, $name);

		$questions = $this->getQuestions()->findAll();

		$form->addGroup("Filtrovat otázky");

		foreach($questions AS $question) {
			$form->addCheckbox("question" . $question->id_question, $question->question);
 		}

		if (isset($this->questions)) {
			$defaults = array();
			foreach($this->questions AS $question) {
				$defaults['question' . $question] = TRUE;
				$form->setDefaults($defaults);
			}
		}

		$form->addSubmit("filter", "Zobrazit");
		$form->onSubmit[] = array($this, "questionFormSubmitted");

		return $form;
	}

}
