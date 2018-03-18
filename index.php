<?php

// Mostra todos os erros
error_reporting(E_ALL);
ini_set("display_errors", 1); 

$baseUrl = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], 'index.php'));
define('BASE_URL', $baseUrl);
define('APPLICATION_PATH', __DIR__ . '/');

require_once "vendor/autoload.php";
	
$application = new Core\Application();
$application->bootstrap();