<?php
namespace App\Model;

use DibiConnection;
use Nette\InvalidArgumentException;

abstract class AbstractModel
{

	/** @var DibiConnection */
	private $connection;

	public function __construct(DibiConnection $connection)
	{
		$this->connection = $connection;
	}

	/**
	 *
	 * @return DibiConnection
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