<?php

$smvc = '.';

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);

if (!is_dir($smvc) and is_dir(ROOT . $smvc)) {
	$smv = ROOT . $smvc;
}

define('SMVC', realpath($smvc) . DS);

unset($smvc);

if (file_exists(SMVC . 'vendor' . DS . 'autoload.php')) {
	require_once SMVC . 'vendor' . DS . 'autoload.php';
} else {
	echo '<h1>Please install via composer.json</h1>';
	echo "<p>Install Composer instructions: <a href='https://getcomposer.org/doc/00-intro.md#globally'>https://getcomposer.org/doc/00-intro.md#globally</a></p>";
	echo "<p>Once composer is installed navigate to the working directory in your terminal/command promt and enter 'composer install'</p>";
	exit;
}

if (!is_readable(SMVC . 'application' . DS . 'core' . DS . 'Config.php')) {
	die('No Config.php found, configure and rename Config.new.php to Config.php in application/core');
}

define('ENVIRONMENT', 'development');

if (defined('ENVIRONMENT')) {
	switch (ENVIRONMENT) {
		case 'development':
			error_reporting(E_ALL);
			break;
		case 'production':
			error_reporting(0);
			break;

		default:
			exit('The application environment is not set correctly.');
			break;
	}
}

new core\Config();

require_once SMVC . 'application' . DS . 'core' . DS . 'Routes.php';