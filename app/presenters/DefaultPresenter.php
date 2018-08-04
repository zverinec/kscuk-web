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

	public function renderArchiv() {

		$years = [];
		$files = scandir(__DIR__ . "/../import/archive", SCANDIR_SORT_DESCENDING);

		foreach ($files as $file) {
			$file = __DIR__ . "/../import/archive/" . $file;

			if (is_file($file)) {
				$years []= $this->getArchiveYear($file);
			}
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
