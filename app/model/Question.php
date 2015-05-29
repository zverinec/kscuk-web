<?php
namespace App\Model;

class Question extends AbstractModel
{

	public function findAll($category = NULL) {
		if (empty($category)) {
			return $this->getConnection()->dataSource('SELECT * FROM [question]');
		}
		else {
			return $this->getConnection()->dataSource('SELECT * FROM [question] WHERE [category] = %s', $category);
		}
	}

}
