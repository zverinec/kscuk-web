<?php
namespace App\Presenters;

use App\Components\IRegistrationFactory;
use Tracy;

class DefaultPresenter extends BasePresenter
{
	/** @var IRegistrationFactory */
	private $registrationFactory;

	public function injectDefault(IRegistrationFactory $registrationFactory)
	{
		$this->registrationFactory = $registrationFactory;
	}

	public function renderDefault() {}

	public function renderArchive() {

		$years = [];
		$files = glob(__DIR__ . "/../data/archive/*.php", GLOB_BRACE);

		foreach ($files as $file) {
			$years []= $this->getArchiveYear($file);
		}

		$this->template->years = $years;
	}

	public function renderRegistration() {}

	public function createComponentRegistration()
	{
		return $this->registrationFactory->create();
	}

	private function getArchiveYear($file) {
		include "$file";
		return $year;
	}

}
