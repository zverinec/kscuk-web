<?php
namespace App\Model;
use App\Utils\Parameters;
use Nette;
use Nette\InvalidStateException;
use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;

class UserAuthenticator implements IAuthenticator
{
	/** @var Parameters */
	private $parameters;

	public function __construct(Parameters $parameters)
	{
		$this->parameters = $parameters;
	}

	public function authenticate(array $credentials)
	{
		$config = $this->parameters->getAdmin();
		if (!isset($config->pass)) {
			throw new InvalidStateException("There is no admin password in the configuration!");
		}

		$password = $credentials[IAuthenticator::PASSWORD];
		if ($password != $config->pass) {
			throw new AuthenticationException("The password does not match", IAuthenticator::INVALID_CREDENTIAL);
		}
		return new Identity('org');
	}

}
