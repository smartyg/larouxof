<?php
/*
* This class contains all static (helper) functions.
*/
abstract class Functions
{
	final function splitCall(string $call, string $module = ""): ?array
	{
		$path = explode('/', $call);
		if(is_empty($path[0])) $path = array_slice($path, 1);
		if($module != "")
		{
			if($path[0] == $module)
				$path = array_slice($path, 1);
			else
				return null;
		}
		return $path;
	}
}

?>