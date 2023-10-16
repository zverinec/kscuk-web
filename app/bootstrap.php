<?php

use Dibi\Connection;
use App\Model\Import;

require __DIR__ . '/../vendor/autoload.php';

use Nette\Bootstrap\Configurator;

$configurator = new Configurator;

$remoteIP = $_SERVER['REMOTE_ADDR'];
$allowedIP = array("127.0.0.1", "::1", "192.168.99.1", "172.24.0.1", "172.20.0.1", "192.168.0.1");
$configurator->setDebugMode(in_array($remoteIP, $allowedIP));
$configurator->enableTracy(__DIR__ . '/../log');



$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

$container = $configurator->createContainer();

// Setup router
$container->addService('router', App\RouterFactory::createRouter());

// Auto import when needed
$tables = $container->getByType(Connection::class)->getDatabaseInfo()->getTables();
if (empty($tables)) {
	$import =$container->getByType(Import::class);
	$import->installDatabase();
}
return $container;
