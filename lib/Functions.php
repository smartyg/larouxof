<?php

namespace LaRouxOf;

use ReflectionClass;
use PDO;
/*
* This class contains all static (helper) functions.
*/

abstract class Functions
{
	final public static function splitCall(string $call, string $module = ""): ?array
	{
		$path = explode('/', $call);
		if(empty($path[0])) $path = array_slice($path, 1);
		if($module != "")
		{
			if($path[0] == $module)
				$path = array_slice($path, 1);
			else
				return null;
		}
		if(count($path) > 0 && empty(end($path))) array_pop($path);
		return $path;
	}

	final public static function executeCall(PDO $connection, array $path)
	{
		try
		{
			// First item in path is the main class name.
			$class = __NAMESPACE__ . '\\' . $path[0];
			// Name of the method of the main class needed to inizialize the class.
			$method = 'load' . $path[0];
			// Check if main class exists.
			if(!class_exists($class)) throw new \Exception("requested class `" . $class . "` does not exists.");
			$reflect = new ReflectionClass($class);
			// Check if method exists
			if(!$reflect->hasMethod($method)) throw new \Exception("requested class does not have a method `" . $method . "`.");
			$reflect_method = $reflect->getMethod($method);
			// Make sure the method is static, as we do not have an initialized object yet.
			if(!$reflect_method->isStatic()) throw new \Exception($class . "::" . $method . " is not a static method.");
			// Substract one from the count as this is the PDO object that is provided seperately.
			$n_param = $reflect_method->getNumberOfRequiredParameters() - 1;
			// The next $n_param are needed to initialize the main class (only the number of required parameters will be passed, any other parameters will get there default value).
			$args = array_slice($path, 1, $n_param);
			// Prepend the connection object to the beginning of the argument array, also save the number of new items
			$n_args = array_unshift($args, $connection);
			if($n_args < $n_param) throw new \Exception($class . "::" . $method . " requires at least " . $n_obj_param . " arguments, only " . count($args) . " are given.");
			// Here we really call the load method of the main class with the correct number of arguments.
			$obj = $reflect_method->invokeArgs(null, $args);

			// Name of the requested method on the returned object.
			$obj_method = $path[$n_param + 1];
			// All other arguments are passed to the method.
			$obj_method_args = array_slice($path, $n_param + 2);

			$obj_reflect = new ReflectionClass($obj);
			// Check in the requested method exists on the returned object.
			if(!$obj_reflect->hasMethod($obj_method)) throw new \Exception("method `" . $obj_method . "` does not exist on object `" . get_class($obj) . "`.");
			$obj_reflect_method = $obj_reflect->getMethod($obj_method);
			// Make sure the method is public, private and restricted methods are not allowed to be exposed.
			if(!$obj_reflect_method->isPublic()) throw new \Exception("method `" . $obj_method . "` of object `" . get_class($obj) . "` is not a public method.");
			// Count the number of required parameters needed for the requested method.
			$n_obj_param = $obj_reflect_method->getNumberOfRequiredParameters();
			if(count($obj_method_args) < $n_obj_param) throw new \Exception(get_class($obj) . "::" . $obj_method . " requires at least " . $n_obj_param . " arguments.");
			// Finally make the call the the reqested method and return the answer.
			return $obj_reflect_method->invokeArgs($obj, $obj_method_args);
		}
		catch(ReflectionException $e)
		{
			throw new Exception("API error: " . $e->message);
		}
	}

	final public static function loadClass(PDO $connection, string $link)
	{
		$path = Functions::splitCall($link);
		if(count($path) < 2) throw new \Exception("URI must at least contain 2 elements.");
		$class = __NAMESPACE__ . '\\' . $path[0];
		$class_link = implode('/', array_slice($path, 1));
		if(!class_exists($class)) throw new \Exception("Class `" . $class . "` can not be found.");
		$ifaces = class_implements($class);
		if(!isset($ifaces['LaRouxOf\iWebpage'])) throw new \Exception("Class `" . $class . "` does not implement the iWebpage interface.");
		$obj = $class::loadByUI($connection, $class_link);
		if(!is_object($obj) || !is_a($obj, $class)) throw new \Exception($class . "::loadByUI() did not return an instance of `" . $class . "`.");
		return $obj;
	}
}

?>