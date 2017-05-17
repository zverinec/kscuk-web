<?php
require __DIR__ . '/../vendor/autoload.php';

use Nette\Application\Routers\Route;

$configurator = new Nette\Configurator;

$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

$container = $configurator->createContainer();

// Turn on HTTPS when request is secured
/** @var Request $httpRequest */
$httpRequest = $container->getByType('Nette\\Http\\Request');
if ($httpRequest->isSecured()) {
       Route::$defaultFlags = Route::SECURED;
}

// Setup router
$container->addService('router', App\RouterFactory::createRouter());

// Auto import when needed
$tables = $container->getByType('\\DibiConnection')->getDatabaseInfo()->getTables();
if (empty($tables)) {
	$import =$container->getByType('\\App\\Model\\Import');
	$import->installDatabase();
}
return $container;
