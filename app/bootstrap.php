<?php


// Step 1: Load Nette Framework
// this allows Nette to load classes automatically so that
// you don't have to litter your code with 'require' statements
require_once LIBS_DIR . '/Nette/loader.php';

// Step 2: Register auto loader
$loader = new RobotLoader();
$loader->addDirectory(APP_DIR);
$loader->addDirectory(LIBS_DIR);
$loader->register();

// Step 3: Enable Nette\Debug
// for better exception and error visualisation

Environment::loadConfig(APP_DIR . '/config.ini');

$debug = Environment::getConfig("debug");

if ($debug->enable) {

	Debug::enable(Debug::DEVELOPMENT, $debug->log, $debug->email);
	Environment::getApplication()->catchExceptions = false;

	if ($debug->profiler) {
		Debug::enableProfiler();
	}
}

// Step 4: Set up the sessions.
// FIXME
Environment::getSession()->setExpiration(60*60*24*7);
Environment::getUser()->setNamespace("kscuk");

// Step 5: Get the front controller
$application = Environment::getApplication();

// Step 6: Setup application router
$router = $application->getRouter();

$router[] = new Route (
	"/kscuk/<presenter>/<action>",
	array(
		"presenter" => "Default",
		"action" => "default"
	)
);

// Step 7: Connect to the database
dibi::connect(Environment::getConfig("database"));

// auto import
$tables = dibi::getConnection()->getDatabaseInfo()->getTables();
if (empty($tables)) {
	$import = new Import();
	$import->installDatabase();
}

// session
Environment::getSession()->setExpiration("+7 days");
Environment::getSession()->start();

// smtp mailer
Environment::getServiceLocator()->addService('mailer', new SmtpMailer(Environment::getConfig("mailer")->toArray()));

// Step 8: Run the application!
$application->run();
