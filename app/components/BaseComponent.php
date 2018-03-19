<?php
namespace App\Components;

use App\Utils\Helpers;
use Nette\Application\UI\Control;
use Nette\Templating\ITemplate;

abstract class BaseComponent extends Control
{

	protected function beforeRender() {}

	protected function startUp() {}

	public function render()
	{
		// Add one stage of lifecycle
		$this->beforeRender();

		// Automatic rendering in case of no render method
		$this->getTemplate()->render();
	}

	/**
	 * Returns path to directory of component
	 *
	 * @return string Path to directory
	 */
	protected function getPath()
	{
		$reflector = new \ReflectionClass(get_class($this));
		return dirname($reflector->getFileName());
	}

	/**
	 * Returns name of component (based on file name)
	 *
	 * @return string Name of component
	 */
	protected function getBaseName()
	{
		$reflector = new \ReflectionClass(get_class($this));
		return str_replace('.php','', basename($reflector->getFileName()));
	}

	protected function createTemplate($class = NULL)
	{
		$template = $this->getControlTemplate($this->getBaseName(),$class);
		return $template;
	}

	/**
	 * Create and return template with given name from control's class directory
	 *
	 * @param string $name Filename of template without extensions
	 * @param string $class Class name of template to use (e.g. FileTemplate)
	 * @return ITemplate
	 */
	protected function getControlTemplate($name, $class = NULL)
	{
		$template = parent::createTemplate($class);
		$template->setFile($this->getPath(). '/'. $name . '.latte');
		$template->getLatte()->addFilter('texy', Helpers::getHelper('texy'));
		return $template;
	}
}
