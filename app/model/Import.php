<?php
class Import extends AbstractModel {

	public function clearDatabase() {
		$this->getConnection()->query("DROP TABLE IF EXISTS [answer]");
		$this->getConnection()->query("DROP TABLE IF EXISTS [registered]");
		$this->getConnection()->query("DROP TABLE IF EXISTS [question]");
		$this->getConnection()->query("DROP TABLE IF EXISTS [health_declaration]");
	}

	/**
	 *  It installs tables and views into the database.
	 *
	 */
	public function installDatabase() {
		$this->getConnection()->loadFile(IMPORT_DIR . "/tables.sql");
		$this->getConnection()->loadFile(IMPORT_DIR . "/views.sql");
		self::loadData();
	}

	private function loadData() {
		$questions = simplexml_load_file(IMPORT_DIR . "/questions/current.xml");
		foreach ($questions AS $question) {
			$choices = array();
			if (isset($question->choices)) {
				foreach ($question->choices->choice AS $choice) {
					$choices[] = (string) $choice;
				}
			}
			$this->getConnection()->insert('question', array(
				'question'	=> (string) $question->text,
				'info'		=> (string) $question->info,
				'category'	=> (string) $question['category'],
				'form_type'	=> (string) $question['form'],
				'choices'	=> (string) implode($choices, '|'),
				'required'	=> (bool) (isset($question['required']) && $question['required'] == 'true' ? 1 : 0)
			))->execute();
		}
	}

}