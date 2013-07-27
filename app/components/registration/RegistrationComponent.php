<?php
class RegistrationComponent extends BaseComponent
{

	/** @persistent */
	public $category;

	private $categories;
	private $categoriesRev;

	private $skipPhoto = false;

	public function  __construct(IComponentContainer $parent = NULL, $name = NULL) {
		parent::__construct($parent, $name);
		$config = Environment::getConfig('registration');
		$this->categoriesRev = $config->categories->toArray();
		$this->categories = array_keys($config->categories->toArray());
		$this->skipPhoto = !((bool) $config->photo);
	}

	public function createComponentImageForm($name) {
		return $this->buildImageForm($name);
	}

	public function createComponentQuestionForm($name) {
		return $this->buildQuestionForm($name, $this->getCategory());
	}

	public function imageFormSubmitted(Form $form) {
		// If photo form was skipped, than there are some things left in the form
		if($this->skipPhoto) {
			$this->storeAnswers($form);
		}
		$session = Environment::getSession('question-form-answers');
		foreach($this->categories AS $category) {
			if (empty($session[$category])) {
				$this->getPresenter()->flashMessage('Bohužel jsi vyplňoval(a) formulář moc dlouho a nejsme schopni tě na K-SCUK přihlásit. Zkus to prosím ještě jednou, a pokud se tento problém bude opakovat, napiš nám e-mail.', 'error');
				$this->redirect('this');
			}
		}
		$registered = $this->getPeople()->create();
		if(!$this->skipPhoto) {
			$values = $form->getValues();
			$tmpFile = $values["image"]->getTemporaryFile();
			$orgFile = $values["image"]->getName();
			Tools::tryError();
			$extension = pathinfo($orgFile, PATHINFO_EXTENSION);
			if (empty($extension)) {
				$extension = 'jpeg';
			}
			copy($tmpFile, WWW_DIR . '/storage/people/' . $registered . '.' . $extension);
			if (Tools::catchError($message)) {
					$this->getPresenter()->flashMessage('Tvá fotka nejde nahrát. Zkus to prosím ještě jednou, a pokud se tento problém bude opakovat, napiš nám e-mail.', 'error');
					$this->redirect('this');
			}
		}
		$targetMail = null;
		foreach($this->getQuestions()->findAll() AS $question) {
			if (empty($session[$question->id_question])) {
				continue;
			}
			if ($question->form_type == 'checkbox') {
				$answer = implode('|', $session[$question->id_question]);
			}
			else {
				$answer	= $session[$question->id_question];
			}
			if(strpos(strtolower($question->question), 'e-mail') !== FALSE) {
				$targetMail = $answer;
			}
			try {
				$this->getPeople()->saveAnswer($registered, $question->id_question, $answer);
			}
			catch(Exception $e) {
				$this->getPresenter()->flashMessage('Během přihlašování se vyskytla chyba. Zkus to prosím ještě jednou, a pokud se problém bude opakovat, napiš nám e-mail.', 'error');
				$this->getPresenter()->redirect('this');
			}
		}
		$session->remove();
		$config = Environment::getConfig('admin');
		if (isset($config->mail)) {
			try {
				$mail = new Mail();
				$mail->setMailer(Environment::getService('mailer'));
				$mail->setSubject('K-SCUK: přihlášený účastník');
				$mail->setEncoding('UTF-8');
				$mail->addTo($config->mail);
				if($targetMail != null) {
					$mail->setFrom($targetMail);
				} else {
					$mail->setFrom($config->mail);
				}
				$template = new Template();
				$template->questions = $this->getQuestions()->findAll();
				$template->answers = $this->getPeople()->findAnswers($registered)->fetchAssoc('id_question');
				$template->setFile(APP_DIR . '/templates/mail/registration.phtml');
				$template->registerFilter(new LatteFilter());
				$template->registerHelper('texy', Helpers::getHelper('texy'));
				$mail->setHtmlBody($template);
				$mail->send();
				// Send mail to attendee
				if($targetMail != null) {
					$mail2 = new Mail();
					$mail2->setMailer(Environment::getService('mailer'));
					$mail2->addTo($targetMail);
					$mail2->setSubject('K-SCUK: potvrzení přihlášení');
					$mail2->setFrom($config->mail);
					$template2 = new Template();
					$template2->setFile(APP_DIR . '/templates/mail/confirm.phtml');
					$template2->registerFilter(new LatteFilter());
					$template2->registerHelper('texy', Helpers::getHelper('texy'));
					$mail2->setHtmlBody($template2);
					$mail2->send();
				}
			}
			catch(Exception $e) {
				error_log($e->getTraceAsString());
			}
		}
		$this->getPresenter()->flashMessage('Děkujeme, že ses přihlásil(a) na K-SCUK. Brzy ti pošleme e-mail s dalším instrukcemi.', 'success');
		$this->getPresenter()->redirect('Default:default');
	}

	public function questionFormSubmitted(Form $form) {
		$registration = Environment::getConfig('registration');
		if(new DateTime53() < DateTime53::from($registration['start'])) {
			$form->addError('Registrace účastníků ještě nezačala.');
			return;
		}
		if(new DateTime53() > DateTime53::from($registration['end'])) {
			$form->addError('Registrace účastníků již bohužel skončila.');
			return;
		}
		$this->storeAnswers($form);
		if ($form['continue']->isSubmittedBy()) {
			$next = $this->nextCategory($form['category']->getValue());
			if ($next !== NULL)	{
				$this->category = $next;
				$this->resetQuestionForm();
			}
			else {
				$this->category = 'image';
			}
		}
		else {
			$previous = $this->previousCategory($form['category']->getValue());
			if ($previous !== NULL)	{
				$this->category = $previous;
				$this->resetQuestionForm();
			}
		}
		$this->redirect('this');
	}

	protected function beforeRender() {
		if ($this->getCategory() != 'image') {
			$this->getTemplate()->form = $this->getComponent('questionForm');
		}
		else {
			$this->getTemplate()->form = $this->getComponent('imageForm');
		}
		$headers = array(
			'personal'		=> 'Tvé personálie',
			'interesting'	=> 'Zvídavé dotazy',
			'organization'	=> 'Organizační dotazy',
			'image'			=> 'Fotka'
		);
		$this->getTemplate()->state = $this->getCategory();
		$this->getTemplate()->header = $headers[$this->getCategory()];
	}

	private function buildImageForm($name) {
		$form = new AppForm($this, $name);

		$group = $form->addGroup('Tvá fotka');
		$el = Html::el('fieldset');
		$el->class = 'required';
		$group->setOption('container', $el);
		$form->addFile('image', '')
				->addRule(FORM::FILLED, 'My tu fotku opravdu chceme :-)')
				->addRule(Form::MAX_FILE_SIZE, 'Fotka nesmí být větší než 1MB.', 1024 * 1024)
				->setOption('description', 'Fotka nesmí být větší než 1MB a její větší část by měl zabírat tvůj obličej.');

		$form->addGroup();
		$form->addSubmit('register', 'Přihlásit se.');
		$form->onSubmit[] = array($this, 'imageFormSubmitted');

		return $form;
	}

	private function buildQuestionForm($name, $category) {
		$form = new AppForm($this, $name);
		$number = 0;
		$defaults = array();
		$questions  = $this->getQuestions()->findAll($category);
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
			switch($question->form_type) {
				case 'checkbox':
					foreach($this->parseChoices($question->choices) AS $choice) {
						$form->addCheckbox('question' . $question->id_question . strtr(String::webalize($choice), array('-' => '')), $choice);
						if($answer != NULL && in_array($choice, $answer)) {
							$defaults['question' . $question->id_question . strtr(String::webalize($choice), array('-' => ''))] = TRUE;
						}
					}
					break;
				case 'radiobox':
					$form->addRadioList('question' . $question->id_question, '', $this->parseChoices($question->choices));
					if ($answer != NULL) {
						$defaults['question' . $question->id_question] = $answer;
					}
					if ($question->required) {
						$form['question' . $question->id_question]->addRule(Form::FILLED, "Chybí odpověď na otázku '".$question->question."'");
					}
					break;
				case 'selectbox':
					$form->addSelect('question' . $question->id_question, '', $this->parseChoices($question->choices));
					if ($answer != NULL) {
						$defaults['question' . $question->id_question] = $answer;
					}
					if ($question->required) {
						$form['question' . $question->id_question]->addRule(Form::FILLED, "Chybí odpověď na otázku '".$question->question."'");
					}
					break;
				case 'text':
					$form->addText('question' . $question->id_question, '');
					if ($answer != NULL) {
						$defaults['question' . $question->id_question] = $answer;
					}
					if ($question->required) {
						$form['question' . $question->id_question]->addRule(Form::FILLED, "Chybí odpověď na otázku '".$question->question."'");
					}
					break;
				case 'textarea':
					$form->addTextArea('question' . $question->id_question, '');
					if ($answer != NULL) {
						$defaults['question' . $question->id_question] = $answer;
					}
					if ($question->required) {
						$form['question' . $question->id_question]->addRule(Form::FILLED, "Chybí odpověď na otázku '".$question->question."'");
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
		if(end($this->categories) == $this->category && $this->skipPhoto == true) {
			$form->onSubmit[] = array($this, 'imageFormSubmitted');
		} else {
			$form->onSubmit[] = array($this, 'questionFormSubmitted');
		}


		$form->setDefaults( $defaults);
		$form->setValues(array('category' => $category));

		$renderer = $form->getRenderer();
		$renderer->wrappers['controls']['container'] = NULL;
		$renderer->wrappers['pair']['container'] = 'div';
		$renderer->wrappers['label']['container'] = NULL;
		$renderer->wrappers['control']['container'] = NULL;
		return $form;
	}

	private function parseChoices($choices) {
		$choices = explode('|', $choices);
		$result = array();
		foreach ($choices AS $choice) {
			$result[$choice] = $choice;
		}
		return $result;
	}

	private function getStoredAnswer($id) {
		$session = Environment::getSession('question-form-answers');
		return isset($session[$id]) ? $session[$id] : NULL;
	}

	private function storeAnswers(Form $form) {
		$values = $form->getValues();
		$questions = $this->getQuestions()->findAll($values['category'])->fetchAll();
		$toSave = array();
		foreach($questions AS $question) {
			if ($question->form_type == 'checkbox') {
				$toSave[$question->id_question] = array();
				foreach($this->parseChoices($question->choices) AS $choice) {
					$webalized = strtr(String::webalize($choice), array('-' => ''));
					if (!empty($values['question' . $question->id_question . $webalized])) {
						$toSave[$question->id_question][] = $choice;
					}
				}
			}
			else {
				if (!empty($values['question' . $question->id_question])) {
					$toSave[$question->id_question] = $values['question' . $question->id_question];
				}
			}
		}
		$session = Environment::getSession('question-form-answers');
		foreach($toSave AS $key => $value) {
			$session[$key] = $value;
		}
		$session[$values['category']] = TRUE;
	}

	private function getCategory() {
		if (!isset($this->category)) {
			$this->category = 'personal';
		}
		return $this->category;
	}

	private function nextCategory($category) {
		if ($this->categoriesRev[$category] == count($this->categories) - 1) {
			return null;
		}
		else {
			return $this->categories[$this->categoriesRev[$category] + 1];
		}
	}

	private function previousCategory($category) {
		if (!isset($this->categoriesRev[$category]) || $this->categoriesRev[$category] == 0) {
			return null;
		}
		else {
			return $this->categories[$this->categoriesRev[$category] - 1];
		}
	}

	private function resetQuestionForm() {
		$form = $this->getComponent('questionForm');
		$this->removeComponent($form);
		$this->getComponent('questionForm');
	}

}
