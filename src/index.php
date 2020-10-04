<?php

namespace LaRouxOf;

ob_start();

error_reporting(E_ALL);

// Enable autoloading of classes.
function autoloader(string $class) {
	$file = str_replace(__NAMESPACE__ . '\\', '../lib/', $class);
	$file = str_replace('\\', '/', $file);
	include $file . '.php';
}
spl_autoload_register(__NAMESPACE__ . '\autoloader');

$uri = $_SERVER['REQUEST_URI'];
$default_uri = "/Page/Welcome";
if($uri == "/") $uri = $default_uri;

$request = Functions::LoadOutputClass(Database::connect(), $uri);

$request->render();

ob_clean();

$request->output();

ob_end_flush();
?>