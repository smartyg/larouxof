<?php

require_once settings.php;

final class Database
{
	private static PDO $connection = null;

	public static function connect()
	{
		if(self::$connection != null)
			return self::$connection;
		$dsn = 'mysql:dbname=' . Settings::SQL_DB . ';host=' SETTINGS::SQL_HOST;
		self::$connection = new PDO($dsn, Settings::SQL_USERNAME, SQL_PASSWORD);
		return self::$connection;
	}
}

?>