<?php
namespace LaRouxOf\Test;

require_once __DIR__ . "/../../vendor/autoload.php";
#require_once __DIR__ . "/../../src/settings.php";
require_once __DIR__ . "/../../lib/iLinkable.php";
require_once __DIR__ . "/../../lib/iWebpage.php";
require_once __DIR__ . "/../../lib/Page.php";
require_once __DIR__ . "/../../lib/Gallery.php";
require_once __DIR__ . "/../../lib/Item.php";
require_once __DIR__ . "/../../lib/Database.php";
require_once __DIR__ . "/../../lib/Functions.php";
require_once __DIR__ . "/FunctionsClass.php";

use LaRouxOf\Functions;

class TestFunctionsExecuteCall extends \PHPUnit\Framework\TestCase
{
	public function testFunctionsExecuteCall1()
	{
		// Creat a fake database connection, because we are working with a test class this connection will never be used.
		// Make maethods prepare and query raise an exception, in case they do get called we are notified.
		$pdoMock = $this->createMock(\PDO::class);
		$pdoMock->method('prepare')
                ->will($this->throwException(new \Exception()));
		$pdoMock->method('query')
                ->will($this->throwException(new \Exception()));

		$expect[] = 'TestClass';
		$expect[] = 'test';
		$expect[] = 'concatenate';
		$expect[] = 'String';
		$result = Functions::executeCall($pdoMock, $expect);

		$this->assertIsString($result);
		$this->assertEquals($expect[1] . $expect[3], $result);
	}

	public function testFunctionsExecuteCall2()
	{
		// Creat a fake database connection, because we are working with a test class this connection will never be used.
		// Make maethods prepare and query raise an exception, in case they do get called we are notified.
		$pdoMock = $this->createMock(\PDO::class);
		$pdoMock->method('prepare')
                ->will($this->throwException(new \Exception()));
		$pdoMock->method('query')
                ->will($this->throwException(new \Exception()));

		$expect[] = 'TestClass';
		$expect[] = '';
		$expect[] = 'concatenate';
		$expect[] = 'String';
		$result = Functions::executeCall($pdoMock, $expect);

		$this->assertIsString($result);
		$this->assertEquals($expect[1] . $expect[3], $result);
	}

	public function testFunctionsExecuteCall3()
	{
		// Creat a fake database connection, because we are working with a test class this connection will never be used.
		// Make maethods prepare and query raise an exception, in case they do get called we are notified.
		$pdoMock = $this->createMock(\PDO::class);
		$pdoMock->method('prepare')
                ->will($this->throwException(new \Exception()));
		$pdoMock->method('query')
                ->will($this->throwException(new \Exception()));

		$this->expectException(\Exception::class);
		$expect[] = 'TestClass';
		$expect[] = 'test';
		$expect[] = 'NonExistingMethod';
		$expect[] = 'String';
		$result = Functions::executeCall($pdoMock, $expect);
	}

	public function testFunctionsExecuteCall4()
	{
		// Creat a fake database connection, because we are working with a test class this connection will never be used.
		// Make maethods prepare and query raise an exception, in case they do get called we are notified.
		$pdoMock = $this->createMock(\PDO::class);
		$pdoMock->method('prepare')
                ->will($this->throwException(new \Exception()));
		$pdoMock->method('query')
                ->will($this->throwException(new \Exception()));

		$this->expectException(\Exception::class);
		$expect[] = 'NonExistingClass';
		$expect[] = 'test';
		$expect[] = 'NonExistingMethod';
		$expect[] = 'String';
		$result = Functions::executeCall($pdoMock, $expect);
	}
}
?>