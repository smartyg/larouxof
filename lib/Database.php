<?php

namespace LaRouxOf;

use PDO;

require_once __DIR__ . "/../settings.php";

final class Database
{
	private static ?PDO $connection = null;

	public static function connect()
	{
		if(self::$connection != null)
			return self::$connection;
		#$dsn = 'mysql:dbname=' . Settings::SQL_DB . ';host=' . Settings::SQL_HOST;
		$dsn = 'sqlite:' . __DIR__ . '/../test.db';
		self::$connection = new PDO($dsn, Settings::SQL_USERNAME, Settings::SQL_PASSWORD, array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		return self::$connection;
	}
}

?>