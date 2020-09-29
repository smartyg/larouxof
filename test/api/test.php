<?php
namespace LaRouxOf\Test;

require_once __DIR__ . "/../../vendor/autoload.php";
#require_once __DIR__ . "/../../src/settings.php";
require_once __DIR__ . "/../../src/classes/iLinkable.php";
require_once __DIR__ . "/../../src/classes/iWebpage.php";
require_once __DIR__ . "/../../src/classes/Page.php";
require_once __DIR__ . "/../../src/classes/Gallery.php";
require_once __DIR__ . "/../../src/classes/Item.php";
require_once __DIR__ . "/../../src/classes/Database.php";
require_once __DIR__ . "/../../src/classes/Functions.php";
require_once __DIR__ . "/FunctionsClass.php";
require_once __DIR__ . "../lib/DatabaseTester.php";

use LaRouxOf\Functions;

class TestFunctionsExecuteCall extends \PHPUnit\Framework\TestCase
{
	private $test_connection;

	public static function setUpBeforeClass(): void
    {
         $this->test_connection = new DatabaseTester();
    }

	protected function setUp(): void
    {
        $this->test_connection->loadFile();
    }

    public static function tearDownAfterClass(): void
    {
         $this->test_connection->close();
    }

	public function testFunctionsExecuteCall1()
	{
		$expect[] = 'Page';
		$expect[] = '0';
		$expect[] = 'getTitle';
		$result = Functions::executeCall($this->test_connection->getPDO(), $path);

		$this->assertIsString($result);
		$this->assertEquals('Welcome', $result);
	}
}
?>