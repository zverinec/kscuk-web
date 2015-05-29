<?php
namespace App\Utils;

use Nette\InvalidArgumentException;
use Nette\InvalidStateException;
use Nette\Utils\Html;
use Texy;

class Helpers
{
	/** @var Texy */
	private static $texy;

	public static function getHelper($helper) {
		if (empty($helper)) {
			throw new InvalidArgumentException("helper");
		}
		switch ($helper) {
			case "texy": return array(get_class(), 'texyHelper');
				break;
			default:
				throw new InvalidStateException("The helper [$helper] does not exist.");
		}
	}

	public static function texyHelper($input) {
		if (empty(self::$texy)) {
			self::$texy = new Texy();
		}
		return self::$texy->process($input);
	}
	
	public static function addRadioLists($questions,$form,$basePath) {
		if(!is_array($questions)) return;
		$i = 1;
		$bool = array(false => "Ne", true => "Ano");
		foreach($questions as $question) {
			$a = $form->addRadioList($basePath.$i++, $question, $bool)
				->setRequired("Zaškrtněte ANO anebo NE u otázky: ".$question.".");
			$a->getSeparatorPrototype()->setName("");
			$a->getContainerPrototype()->setName("div")->class("yes-no-answer");
		}
	}
	
	public static function makeGroupRequired($group) {
		$el = Html::el('fieldset');
		$el->class = 'required';
		$group->setOption('container', $el);
	}
	
	public static function changeRenderer($form) {
		$renderer = $form->getRenderer();
		$renderer->wrappers['controls']['container'] = NULL;
		$renderer->wrappers['pair']['container'] = 'div';
		$renderer->wrappers['label']['container'] = NULL;
		$renderer->wrappers['control']['container'] = NULL;
		return $form;
	}
}
