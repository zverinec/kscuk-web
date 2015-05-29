<?php
require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

$container = $configurator->createContainer();

// Auto import when needed
$tables = $container->getByType('\\DibiConnection')->getDatabaseInfo()->getTables();
if (empty($tables)) {
	$import =$container->getByType('\\App\\Model\\Import');
	$import->installDatabase();
}
return $container;