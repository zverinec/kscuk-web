<?php
namespace App\Presenters;

use App\Model\Person;
use App\Model\Question;
use App\Utils\Helpers;
use App\Utils\Parameters;
use Nette\Application\BadRequestException;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Template;

class BasePresenter extends Presenter
{

	/** @var Question */
	protected $question;
	/** @var Person */
	protected $person;
	/** @var Parameters */
	protected $parameters;

	public function injectBase(Question $question, Person $person, Parameters $parameters)
	{
		$this->question = $question;
		$this->person = $person;
		$this->parameters = $parameters;
	}

	protected function startUp()
	{
		parent::startup();
	}

	protected function createTemplate(): Template
	{
		$template = parent::createTemplate();

		if ($this->user->isLoggedIn()) {
			$template->logged = TRUE;
		} else {
			$template->logged = FALSE;
		}
		$template->registration = $this->parameters->getRegistration();
		$template->event = $this->parameters->getEvent();
		$template->getLatte()->addFilter('texy', Helpers::getHelper('texy'));
		return $template;
	}

}
