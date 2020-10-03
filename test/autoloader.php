<?php

namespace LaRouxOf\Test;

// Enable autoloading of classes.
function autoloader(string $class) {
	$parts = explode("\\", $class);
	//var_dump($parts);
	if($parts[0] != "LaRouxOf")
		return;
	if($parts[1] == "Test")
	{
		$parts[0] = __DIR__;
		$parts[1] = 'lib';
	}
	else
	{
		$parts[0] = __DIR__ . "/../lib/";
	}
	$file = implode('/', $parts) . '.php';
	if(file_exists($file))
		require_once $file;
/*
	$file = str_replace(__NAMESPACE__ . '\\', '../lib/', $class);
	$file = str_replace('\\', '/', $file);
	include $file . '.php';*/
}
spl_autoload_register(__NAMESPACE__ . '\autoloader');

?>