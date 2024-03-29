<?php
namespace App\Model;

use Dibi\DataSource;
use Nette\InvalidArgumentException;

class Person extends AbstractModel
{

	public function create() {
		$this->getConnection()->insert('registered', array('id_registered' => 0))
			->execute(TRUE);
		return $this->getConnection()->getInsertId();
	}

	public function findByEmail($email) {
		if(empty($email)) {
			throw new InvalidArgumentException;
		}
		$source = $this->getConnection()->dataSource("SELECT [answer].[answer],[question].[question] FROM [answer] INNER JOIN [question] USING([id_question]) WHERE [id_registered] = (SELECT [id_registered] FROM [answer] WHERE [id_question] = (SELECT [id_question] FROM [question] where [question] LIKE %~like~) AND [answer] = %s)","e-mail",$email)->fetchPairs("question","answer");

		return $source;
	}

	public function findEmailById($id_registered) {
		$source = $this->getConnection()->dataSource("SELECT [answer].[answer] FROM [answer] INNER JOIN [question] USING([id_question]) WHERE [question] LIKE %~like~ AND [id_registered] = %s", "e-mail", $id_registered);
		return $source->fetchSingle("answer");
	}

	/** @return DataSource */
	public function findAnswers($person = NULL, $category = NULL) {
		if (empty($category)) {
			$source = $this->getConnection()->dataSource("SELECT [answer].*, category FROM [answer] INNER JOIN [question] USING([id_question])");
		}
		else {
			$source = $this->getConnection()->dataSource("SELECT [answer].*, category FROM [answer] INNER JOIN [question] USING([id_question])  WHERE [category] = %s", $category);
		}
		if (empty($person)) {
			return $source;
		}
		else {
			return $source->where('[id_registered] = %i', $person);
		}
	}

	public function saveAnswer($person, $question, $answer) {
		$this->checkEmpty($person, 'person');
		$this->checkEmpty($question, 'question');
		$this->checkEmpty($answer, 'answer');
		$this->getConnection()->insert('answer', array(
			'id_registered'	=> $person,
			'id_question'	=> $question,
			'answer'		=> $answer
		))->execute();
	}

}
