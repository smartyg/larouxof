<?php
namespace LaRouxOf\Test;

require_once __DIR__ . "/../../lib/iLinkable.php";
require_once __DIR__ . "/../../lib/iWebpage.php";
require_once __DIR__ . "/../../lib/Page.php";
require_once __DIR__ . "/../../lib/Gallery.php";
require_once __DIR__ . "/../../lib/Item.php";
require_once __DIR__ . "/../../lib/Database.php";
require_once __DIR__ . "/../../lib/Functions.php";
require_once __DIR__ . "/../lib/DatabaseTester.php";

use LaRouxOf\Functions;

class TestDataPage extends \PHPUnit\Framework\TestCase
{
	private static $conn = null;

	public static function setUpBeforeClass(): void
    {
		if(self::$conn == null) self::$conn = new DatabaseTester();
    }

	protected function setUp(): void
    {
        self::$conn->loadCSVTable('pages', __DIR__ . "/../data-sets/pagesSet1.csv");
    }

    public static function tearDownAfterClass(): void
    {
         self::$conn->close();
         self::$conn = null;
    }

	public function testPageGetTitle0()
	{
		$path[] = 'Page';
		$path[] = '0';
		$path[] = 'getTitle';
		$result = Functions::executeCall(self::$conn->getPDO(), $path);

		var_dump($result);

		$this->assertIsString($result);
		$this->assertEquals('Welcome', $result);
	}
}
?>