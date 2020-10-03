<?php
/*
namespace LaRouxOf\Test;

require_once __DIR__ . "/../../lib/iLinkable.php";
require_once __DIR__ . "/../../lib/iWebpage.php";
require_once __DIR__ . "/../../lib/Page.php";
require_once __DIR__ . "/../../lib/Gallery.php";
require_once __DIR__ . "/../../lib/Item.php";
require_once __DIR__ . "/../../lib/Database.php";
require_once __DIR__ . "/../../lib/Functions.php";
require_once __DIR__ . "/../lib/DatabaseTester.php";

use LaRouxOf\Page;

class TestPage extends \PHPUnit\Framework\TestCase
{
	private static $conn = null;

	public static function setUpBeforeClass(): void
    {
		if(self::$conn == null) self::$conn = new DatabaseTester();
    }

	protected function setUp(): void
    {
        self::$conn->loadCSVTable('pages', __DIR__ . "/../data-sets/pagesSet1.csv");
        self::$conn->loadCSVTable('content', __DIR__ . "/../data-sets/contentSet1.csv");
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

	public function testPageNew()
	{
		$result = new Page(0, 'Welcome', 'Welcome', self::$conn->getPDO());

		$this->assertIsObject($result);
		$this->assertInstanceOf(Page::class, $result);
	}

	public function testPageGetTitle0()
	{
		$page = new Page(0, 'Welcome', 'Welcome', self::$conn->getPDO());
		$result = $page->getTitle();

		$this->assertIsObject($page);
		$this->assertInstanceOf(Page::class, $page);

		$this->assertIsString($result);
		$this->assertEquals('Welcome', $result);
	}

	public function testPageGetLink0()
	{
		$page = new Page(0, 'Welcome', 'Welcome', self::$conn->getPDO());
		$result = $page->getLink();

		$this->assertIsObject($page);
		$this->assertInstanceOf(Page::class, $page);

		$this->assertIsString($result);
		$this->assertEquals('Page/Welcome', $result);
	}

	public function testPageGetCategory0()
	{
		$page = new Page(0, 'Welcome', 'Welcome', self::$conn->getPDO());
		$result = $page->getCategory();

		$this->assertIsObject($page);
		$this->assertInstanceOf(Page::class, $page);

		$this->assertIsString($result);
		$this->assertEquals('Page', $result);
	}

	public function testPageIsDynamicLoadable()
	{
		$page = new Page(0, 'Welcome', 'Welcome', self::$conn->getPDO());
		$result = $page->isDynamicLoadable();

		$this->assertIsObject($page);
		$this->assertInstanceOf(Page::class, $page);

		$this->assertIsBool($result);
		$this->assertEquals(false, $result);
	}

	public function testPageToHTML()
	{
		$page = new Page(0, 'Welcome', 'Welcome', self::$conn->getPDO());
		$result = $page->toHTML();

		$this->assertIsObject($page);
		$this->assertInstanceOf(Page::class, $page);

		$this->assertIsString($result);
	}

	public function testPageLoadPage()
	{
		$result = Page::loadPage(self::$conn->getPDO(), 'Welcome');

		$this->assertIsObject($result);
		$this->assertInstanceOf(Page::class, $result);
	}

	public function testPageGetTitle1()
	{
		$page = Page::loadPage(self::$conn->getPDO(), 'Welcome');

		$this->assertIsObject($page);
		$this->assertInstanceOf(Page::class, $page);

		$result = $page->getTitle();

		$this->assertIsString($result);
		$this->assertEquals('Welcome', $result);
	}
}*/
?>