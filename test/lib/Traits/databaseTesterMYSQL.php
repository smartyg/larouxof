<?php

namespace LaRouxOf\Test\Traits;

trait databaseTesterMYSQL
{
	abstract protected static funcion getTestSet(): array;

	private static $conn = null;

	public static function setUpBeforeClass(): void
    {
		if(self::$conn == null) self::$conn = \LaRouxOf\Database::connection();
    }

	protected function setUp(): void
    {
        //TODO: load data-set in database;
    }

    protected function tearDown(): void
    {
        //TODO: delete used database;
    }

    public static function tearDownAfterClass(): void
    {
        self::$conn->close();
        self::$conn = null;
    }

	protected static function getDB()
	{
		return self::$conn;
	}
}

?>