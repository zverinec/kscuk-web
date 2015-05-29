<?php
namespace App\Components;

use App\Model\Person;
use App\Model\Question;
use App\Utils\Parameters;
use Exception;
use Latte\Template;
use Nette\Application\UI\Form;
use Nette\Http\Session;
use Nette\Http\SessionSection;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\Utils\ArrayHash;
use Nette\Utils\DateTime;
use Nette\Utils\Html;
use Nette\Utils\Strings;
use Tracy\Debugger;

class Registration extends BaseComponent
{

	/** @var SessionSection */
	private $session;
	/** @var Parameters */
	private $parameters;
	/** @var Question */
	private $question;
	/** @var Person */
	private $person;
	/** @var IMailer */
	private $mailer;

	/** @persistent */
	public $category;

	private $categories;
	private $categoriesRev;

	private $skipPhoto = false;

	public function  __construct(Parameters $parameters, Session $session, Question $question, Person $person, IMailer $mailer)
	{
		$this->parameters = $parameters;
		$this->session = $session->getSection('question-form-answers');
		$this->person = $person;
		$this->question = $question;
		$this->mailer = $mailer;

		$config = $parameters->getRegistration();
		$this->categoriesRev = ArrayHash::from($config->categories);
		$this->categories = array_keys(iterator_to_array(ArrayHash::from($config->categories)));
		$this->skipPhoto = !((bool)$config->photo);
	}

	public function createComponentImageForm($name)
	{
		return $this->buildImageForm($name);
	}

	public function createComponentQuestionForm($name)
	{
		return $this->buildQuestionForm($name, $this->getCategory());
	}

	public function imageFormSubmitted(Form $form)
	{
		// If photo form was skipped, than there are some things left in the form
		if ($this->skipPhoto) {
			$this->storeAnswers($form);
		}
		$session = $this->session;
		foreach ($this->categories AS $category) {
			if (empty($session[$category])) {
				$this->getPresenter()->flashMessage('Bohužel jsi vyplňoval(a) formulář moc dlouho a nejsme schopni tě na K-SCUK přihlásit. Zkus to prosím ještě jednou, a pokud se tento problém bude opakovat, napiš nám e-mail.', 'error');
				$this->redirect('this');
			}
		}
		$registered = $this->person->create();
		if (!$this->skipPhoto) {
			$values = $form->getValues();
			$tmpFile = $values["image"]->getTemporaryFile();
			$orgFile = $values["image"]->getName();
			$extension = pathinfo($orgFile, PATHINFO_EXTENSION);
			if (empty($extension)) {
				$extension = 'jpeg';
			}
			$success = copy($tmpFile, __DIR__ . '/../../../www/storage/people/' . $registered . '.' . $extension);
			if (!$success) {
				$this->getPresenter()->flashMessage('Tvá fotka nejde nahrát. Zkus to prosím ještě jednou, a pokud se tento problém bude opakovat, napiš nám e-mail.', 'error');
				$this->redirect('this');
			}
		}
		$targetMail = null;
		foreach ($this->question->findAll() AS $question) {
			if (empty($session[$question->id_question])) {
				continue;
			}
			if ($question->form_type == 'checkbox') {
				$answer = implode('|', $session[$question->id_question]);
			} else {
				$answer = $session[$question->id_question];
			}
			if (strpos(strtolower($question->question), 'e-mail') !== FALSE) {
				$targetMail = $answer;
			}
			try {
				$this->person->saveAnswer($registered, $question->id_question, $answer);
			} catch (Exception $e) {
				$this->getPresenter()->flashMessage('Během přihlašování se vyskytla chyba. Zkus to prosím ještě jednou, a pokud se problém bude opakovat, napiš nám e-mail.', 'error');
				$this->getPresenter()->redirect('this');
			}
		}
		$session->remove();
		$config = $this->parameters->getAdmin();
		if (isset($config->mail)) {
			try {
				$mail = new Message();
				$mail->setSubject('K-SCUK: přihlášený účastník');
				$mail->setEncoding('UTF-8');
				$mail->addTo($config->mail);
				if ($targetMail != null) {
					$mail->setFrom($targetMail);
				} else {
					$mail->setFrom($config->mail);
				}
				$template = $this->createTemplate();
				$template->questions = $this->question->findAll();
				$template->answers = $this->person->findAnswers($registered)->fetchAssoc('id_question');
				$template->setFile(__DIR__ . '/../../templates/mail/registration.latte');
				$mail->setHtmlBody($template);
				$this->mailer->send($mail);
				// Send mail to attendee
				if ($targetMail != null) {
					$mail2 = new Message();
					$mail2->addTo($targetMail);
					$mail2->setSubject('K-SCUK: potvrzení přihlášení');
					$mail2->setFrom($config->mail);
					$template2 = $this->createTemplate();
					$template2->setFile(__DIR__ . '/../../templates/mail/confirm.latte');
					$mail2->setHtmlBody($template2);
					$this->mailer->send($mail2);
				}
			} catch (Exception $e) {
				Debugger::log($e, Debugger::EXCEPTION);
			}
		}
		$this->getPresenter()->flashMessage('Děkujeme, že ses přihlásil(a) na K-SCUK. Brzy ti pošleme e-mail s dalším instrukcemi.', 'success');
		$this->getPresenter()->redirect('Default:default');
	}

	public function questionFormSubmitted(Form $form)
	{
		$registration = $this->parameters->getRegistration();
		if (new DateTime() < DateTime::from($registration->start)) {
			$form->addError('Registrace účastníků ještě nezačala.');
			return;
		}
		if (new DateTime() > DateTime::from($registration->end)) {
			$form->addError('Registrace účastníků již bohužel skončila.');
			return;
		}
		$this->storeAnswers($form);
		if ($form['continue']->isSubmittedBy()) {
			$next = $this->nextCategory($form['category']->getValue());
			if ($next !== NULL) {
				$this->category = $next;
				$this->resetQuestionForm();
			} else {
				$this->category = 'image';
			}
		} else {
			$previous = $this->previousCategory($form['category']->getValue());
			if ($previous !== NULL) {
				$this->category = $previous;
				$this->resetQuestionForm();
			}
		}
		$this->redirect('this');
	}

	protected function beforeRender()
	{
		if ($this->getCategory() != 'image') {
			$this->getTemplate()->form = $this->getComponent('questionForm');
		} else {
			$this->getTemplate()->form = $this->getComponent('imageForm');
		}
		$headers = array(
			'personal' => 'Tvé personálie',
			'interesting' => 'Zvídavé dotazy',
			'organization' => 'Organizační dotazy',
			'image' => 'Fotka'
		);
		$this->getTemplate()->state = $this->getCategory();
		$this->getTemplate()->header = $headers[$this->getCategory()];
	}

	private function buildImageForm($name)
	{
		$form = new Form($this, $name);

		$group = $form->addGroup('Tvá fotka');
		$el = Html::el('fieldset');
		$el->class = 'required';
		$group->setOption('container', $el);
		$form->addUpload('image', '')
			->addRule(Form::FILLED, 'My tu fotku opravdu chceme :-)')
			->addRule(Form::MAX_FILE_SIZE, 'Fotka nesmí být větší než 1MB.', 1024 * 1024)
			->setOption('description', 'Fotka nesmí být větší než 1MB a její větší část by měl zabírat tvůj obličej.');

		$form->addGroup();
		$form->addSubmit('register', 'Přihlásit se.');
		$form->onSuccess[] = $this->imageFormSubmitted;

		return $form;
	}

	private function buildQuestionForm($name, $category)
	{
		$form = new Form($this, $name);
		$number = 0;
		$defaults = array();
		$questions = $this->question->findAll($category);
		foreach ($questions AS $question) {
			$group = $form->addGroup($question->question);
			if (!empty($question->info)) {
				$group->setOption('description', $question->info);
			}
			if ($question->required) {
				$el = Html::el('fieldset');
				$el->class = 'required';
				$group->setOption('container', $el);
			}
			$answer = $this->getStoredAnswer($question->id_question);
			switch ($question->form_type) {
				case 'checkbox':
					foreach ($this->parseChoices($question->choices) AS $choice) {
						$form->addCheckbox('question' . $question->id_question . strtr(Strings::webalize($choice), array('-' => '')), $choice);
						if ($answer != NULL && in_array($choice, $answer)) {
							$defaults['question' . $question->id_question . strtr(Strings::webalize($choice), array('-' => ''))] = TRUE;
						}
					}
					break;
				case 'radiobox':
					$form->addRadioList('question' . $question->id_question, '', $this->parseChoices($question->choices));
					if ($answer != NULL) {
						$defaults['question' . $question->id_question] = $answer;
					}
					if ($question->required) {
						$form['question' . $question->id_question]->addRule(Form::FILLED, "Chybí odpověď na otázku '" . $question->question . "'");
					}
					break;
				case 'selectbox':
					$form->addSelect('question' . $question->id_question, '', $this->parseChoices($question->choices));
					if ($answer != NULL) {
						$defaults['question' . $question->id_question] = $answer;
					}
					if ($question->required) {
						$form['question' . $question->id_question]->addRule(Form::FILLED, "Chybí odpověď na otázku '" . $question->question . "'");
					}
					break;
				case 'text':
					$form->addText('question' . $question->id_question, '');
					if ($answer != NULL) {
						$defaults['question' . $question->id_question] = $answer;
					}
					if ($question->required) {
						$form['question' . $question->id_question]->addRule(Form::FILLED, "Chybí odpověď na otázku '" . $question->question . "'");
					}
					break;
				case 'textarea':
					$form->addTextArea('question' . $question->id_question, '');
					if ($answer != NULL) {
						$defaults['question' . $question->id_question] = $answer;
					}
					if ($question->required) {
						$form['question' . $question->id_question]->addRule(Form::FILLED, "Chybí odpověď na otázku '" . $question->question . "'");
					}
					break;
			}
		}
		$form->addGroup();

		$form->addHidden('category');

		if ($this->previousCategory($category) != NULL) {
			$form->addSubmit('back', 'Zpět')
				->setValidationScope(FALSE);
		}
		$form->addSubmit('continue', 'Pokračovat');
		if (end($this->categories) == $this->category && $this->skipPhoto == true) {
			$form->onSubmit[] = array($this, 'imageFormSubmitted');
		} else {
			$form->onSubmit[] = array($this, 'questionFormSubmitted');
		}


		$form->setDefaults($defaults);
		$form->setValues(array('category' => $category));

		$renderer = $form->getRenderer();
		$renderer->wrappers['controls']['container'] = NULL;
		$renderer->wrappers['pair']['container'] = 'div';
		$renderer->wrappers['label']['container'] = NULL;
		$renderer->wrappers['control']['container'] = NULL;
		return $form;
	}

	private function parseChoices($choices)
	{
		$choices = explode('|', $choices);
		$result = array();
		foreach ($choices AS $choice) {
			$result[$choice] = $choice;
		}
		return $result;
	}

	private function getStoredAnswer($id)
	{
		$session = $this->session;
		return isset($session[$id]) ? $session[$id] : NULL;
	}

	private function storeAnswers(Form $form)
	{
		$values = $form->getValues();
		$questions = $this->question->findAll($values['category'])->fetchAll();
		$toSave = array();
		foreach ($questions AS $question) {
			if ($question->form_type == 'checkbox') {
				$toSave[$question->id_question] = array();
				foreach ($this->parseChoices($question->choices) AS $choice) {
					$webalized = strtr(Strings::webalize($choice), array('-' => ''));
					if (!empty($values['question' . $question->id_question . $webalized])) {
						$toSave[$question->id_question][] = $choice;
					}
				}
			} else {
				if (!empty($values['question' . $question->id_question])) {
					$toSave[$question->id_question] = $values['question' . $question->id_question];
				}
			}
		}
		$session = $this->session;
		foreach ($toSave AS $key => $value) {
			$session[$key] = $value;
		}
		$session[$values['category']] = TRUE;
	}

	private function getCategory()
	{
		if (!isset($this->category)) {
			$this->category = 'personal';
		}
		return $this->category;
	}

	private function nextCategory($category)
	{
		if ($this->categoriesRev[$category] == count($this->categories) - 1) {
			return null;
		} else {
			return $this->categories[$this->categoriesRev[$category] + 1];
		}
	}

	private function previousCategory($category)
	{
		if (!isset($this->categoriesRev[$category]) || $this->categoriesRev[$category] == 0) {
			return null;
		} else {
			return $this->categories[$this->categoriesRev[$category] - 1];
		}
	}

	private function resetQuestionForm()
	{
		$form = $this->getComponent('questionForm');
		$this->removeComponent($form);
		$this->getComponent('questionForm');
	}

}
