<?php
class UserAuthenticator implements IAuthenticator
{

	public function authenticate(array $credentials) {
		$config = Environment::getConfig("admin");
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
