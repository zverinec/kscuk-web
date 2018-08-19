<?php
namespace App\Components;

use App\Model\Person;
use App\Model\Question;
use Nette\Application\UI\Form;
use App\Model\HealthDeclaration;
use App\Components\IHealthDeclarationFactory;

class People extends BaseComponent
{
	/** @persistent */
	public $questions;
	/** @persistent */
	public $showHealthDeclarations;
	/** @persistent */
	public $printable;

	/** @var HealthDeclaration */
	public $healthDeclaration;
	/** @var IHealthDeclarationFactory */
	public $healthDeclarationFactory;

	/** @var Question */
	private $question;
	/** @var Person */
	private $person;

	public function __construct(Person $person, Question $question, HealthDeclaration $healthDeclaration,
								IHealthDeclarationFactory $healthDeclarationFactory)
	{
		$this->person = $person;
		$this->question = $question;
		$this->healthDeclaration = $healthDeclaration;
		$this->healthDeclarationFactory = $healthDeclarationFactory;
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
		$this->showHealthDeclarations = $values["showHealthDeclarations"];
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
			$people = $this->person->findAnswers(NULL, 'personal')->orderBy('id_registered', 'DESC')->fetchAssoc('id_registered,id_question');
			$this->showHealthDeclarations = true;
		} else {
			$this->getTemplate()->questions = $this->question->findAll()->where('id_question IN %l', explode(';', $this->questions))->fetchAssoc('id_question');
			$people = $this->person->findAnswers(NULL, NULL)->where('id_question IN %l', explode(';', $this->questions))->orderBy('id_registered', 'DESC')->fetchAssoc('id_registered,id_question');
		}

		if (!isSet($this->showHealthDeclarations) || $this->showHealthDeclarations) {
			$emails = array();
			$healthDeclarations = array();
			foreach ($people as $id_registered => $answers) {
				$email = $this->person->findEmailById($id_registered);
				$emails[$id_registered] = $email;
				$hd = $this->healthDeclaration->findByEmail($email);
				$healthDeclarations[$id_registered] = count($hd) > 0 ? true : false;
			}

			$this->getTemplate()->emails = $emails;
			$this->getTemplate()->healthDeclarations = $healthDeclarations;
		}

		$this->getTemplate()->people = $people;
		$this->getTemplate()->printable = $this->printable;
		$this->getTemplate()->showHealthDeclarations = !isSet($this->showHealthDeclarations) ? true : $this->showHealthDeclarations;
	}

	public function createComponentQuestionForm($name)
	{
		$form = new Form($this, $name);

		$questions = $this->question->findAll();

		$form->addGroup("Filtrovat otázky");

		foreach ($questions AS $question) {
			$form->addCheckbox("question" . $question->id_question, $question->question);
		}

		$form->addCheckbox("showHealthDeclarations", "Zdravodeklarace");

		if (isset($this->questions)) {
			$defaults = array();
			foreach (explode(';', $this->questions) AS $question) {
				$defaults['question' . $question] = true;
			}
			$defaults['showHealthDeclarations'] = $this->showHealthDeclarations;
			$form->setDefaults($defaults);
		}

		$form->addSubmit("filter", "Zobrazit");
		$form->onSuccess[] = [$this, 'questionFormSubmitted'];

		return $form;
	}

	public function createComponentHealthDeclaration()
	{
		return $this->healthDeclarationFactory->create();
	}

}
