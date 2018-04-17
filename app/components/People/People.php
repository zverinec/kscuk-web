<?php
namespace App\Components;

use App\Model\Person;
use App\Model\Question;
use Nette\Application\UI\Form;

class People extends BaseComponent
{
	/** @persistent */
	public $questions;
	/** @persistent */
	public $printable;

	/** @var Question */
	private $question;
	/** @var Person */
	private $person;

	public function __construct(Person $person, Question $question)
	{
		$this->person = $person;
		$this->question = $question;
	}

	public function questionFormSubmitted(Form $form)
	{
		$temp = array();
		$values = $form->getValues();
		foreach ($this->question->findAll() AS $question) {
			if ($values['question' . $question->id_question]) {
				$temp[] = $question->id_question;
			}
		}
		$this->questions = implode(';', $temp);
		$this->setPrintable();
		$this->getPresenter()->redirect('this');
	}

	public function setPrintable($printable = TRUE)
	{
		$this->printable = $printable;
	}

	protected function beforeRender()
	{
		if (empty($this->questions)) {
			$this->getTemplate()->questions = $this->question->findAll('personal')->fetchAssoc('id_question');
			$this->getTemplate()->people = $this->person->findAnswers(NULL, 'personal')->orderBy('id_registered', 'DESC')->fetchAssoc('id_registered,id_question');
		} else {
			$this->getTemplate()->questions = $this->question->findAll()->where('id_question IN %l', explode(';', $this->questions))->fetchAssoc('id_question');
			$this->getTemplate()->people = $this->person->findAnswers(NULL, NULL)->where('id_question IN %l', explode(';', $this->questions))->orderBy('id_registered', 'DESC')->fetchAssoc('id_registered,id_question');
		}
		$this->getTemplate()->printable = $this->printable;
	}

	public function createComponentQuestionForm($name)
	{
		$form = new Form($this, $name);

		$questions = $this->question->findAll();

		$form->addGroup("Filtrovat otázky");

		foreach ($questions AS $question) {
			$form->addCheckbox("question" . $question->id_question, $question->question);
		}

		if (isset($this->questions)) {
			$defaults = array();
			foreach (explode(';', $this->questions) AS $question) {
				$defaults['question' . $question] = TRUE;
				$form->setDefaults($defaults);
			}
		}

		$form->addSubmit("filter", "Zobrazit");
		$form->onSuccess[] = [$this, 'questionFormSubmitted'];

		return $form;
	}

}
