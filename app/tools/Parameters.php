<?php
namespace App\Utils;

use Nette\SmartObject;

class Parameters
{
	private $config;

	public function __construct($config)
	{
		$this->config = json_decode(json_encode($config));
	}

	public function getEvent()
	{
		return $this->config->event;
	}

	public function getRegistration()
	{
		return $this->config->registration;
	}

	public function getMailer()
	{
		return $this->config->mailer;
	}

	public function getAdmin()
	{
		return $this->config->admin;
	}
}
