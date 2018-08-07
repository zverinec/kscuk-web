<?php
namespace App\Model;

use Nette\InvalidArgumentException;
use Nette\Utils\ArrayHash;

class HealthDeclaration extends AbstractModel
{
	
	public function findByEmail($email) {
		if(empty($email)) {
			throw new InvalidArgumentException;
		}
		return $this->getConnection()->dataSource("SELECT * FROM [health_declaration] WHERE [email] = %s",$email);
	}

	public function getAll() {
		return $this->getConnection()->dataSource("SELECT * FROM [health_declaration]");
	}
	
	public function save($data) {
		if(!is_array($data) && ! ($data instanceof ArrayHash)) {
			throw new InvalidArgumentException;
		}
		return $this->getConnection()->insert("health_declaration", $data)->execute();
	}

}
