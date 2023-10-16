<?php
namespace App\Model;

use Dibi\Connection;
use Nette\InvalidArgumentException;

abstract class AbstractModel
{

	/** @var Connection */
	private $connection;

	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	/**
	 *
	 * @return Connection
	 */
	protected final function getConnection()
	{
		return $this->connection;
	}

	protected final function checkEmpty($param, $name)
	{
		if (empty($param)) {
			throw new InvalidArgumentException("The paramater [$name] is empty.");
		}
	}

}
