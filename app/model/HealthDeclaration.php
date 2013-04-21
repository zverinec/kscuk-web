<?php
class HealthDeclaration extends AbstractModel
{
	
	public function findByEmail($email) {
		if(empty($email)) {
			throw new InvalidArgumentException;
		}
		return $this->getConnection()->dataSource("SELECT * FROM [health_declaration] WHERE [email] = %s",$email);
	}
	
	public function save($data) {
		if(!is_array($data)) {
			throw new InvalidArgumentException;
		}
		return $this->getConnection()->insert("health_declaration", $data)->execute();
	}

}
