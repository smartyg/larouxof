<?php

namespace LaRouxOf\Test\Traits;

use LaRouxOf\Test\DatabaseTester;

trait databaseTesterSQLite
{
	abstract protected static function getTestSet(): array;

	private static $conn = null;

	public static function setUpBeforeClass(): void
    {
		if(self::$conn == null) self::$conn = new DatabaseTester();
    }

	protected function setUp(): void
    {
		foreach(self::getTestSet() as $table => $data)
		{
			self::$conn->loadCSVTable($table, $data);
		}
    }

    protected function tearDown(): void
    {
        self::$conn->clear();
    }

    public static function tearDownAfterClass(): void
    {
        self::$conn->close();
        self::$conn = null;
    }

	protected static function getDB()
	{
		return self::$conn->getPDO();
	}
}
?>