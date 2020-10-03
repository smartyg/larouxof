<?php

namespace LaRouxOf\Test;

require_once __DIR__ . "/../autoloader.php";
require_once __DIR__ . "/FunctionsClass.php";

use LaRouxOf\Functions;
use LaRouxOf\InternalException;

class TestFunctionsLoadClass extends \PHPUnit\Framework\TestCase
{
	public function testFunctionsLoadClass1()
	{
		// Creat a fake database connection, because we are working with a test class this connection will never be used.
		// Make maethods prepare and query raise an exception, in case they do get called we are notified.
		$pdoMock = $this->createMock(\PDO::class);
		$pdoMock->method('prepare')
                ->will($this->throwException(new \Exception()));
		$pdoMock->method('query')
                ->will($this->throwException(new \Exception()));

		$str = '/TestClass/test';
		$result = Functions::loadClass($pdoMock, $str);
		$expect = 'test';

		$this->assertIsObject($result);
		$this->assertEquals('LaRouxOf\TestClass', get_class($result));
		$this->assertEquals($expect, $result->toHTML());
	}

	public function testFunctionsLoadClass2()
	{
		// Creat a fake database connection, because we are working with a test class this connection will never be used.
		// Make maethods prepare and query raise an exception, in case they do get called we are notified.
		$pdoMock = $this->createMock(\PDO::class);
		$pdoMock->method('prepare')
                ->will($this->throwException(new \Exception()));
		$pdoMock->method('query')
                ->will($this->throwException(new \Exception()));

		$str = '/TestClass//';
		$result = Functions::loadClass($pdoMock, $str);
		$expect = '';

		$this->assertIsObject($result);
		$this->assertEquals('LaRouxOf\TestClass', get_class($result));
		$this->assertEquals($expect, $result->toHTML());
	}

	public function testFunctionsLoadClass3()
	{
		// Creat a fake database connection, because we are working with a test class this connection will never be used.
		// Make maethods prepare and query raise an exception, in case they do get called we are notified.
		$pdoMock = $this->createMock(\PDO::class);
		$pdoMock->method('prepare')
                ->will($this->throwException(new \Exception()));
		$pdoMock->method('query')
                ->will($this->throwException(new \Exception()));

		$this->expectException(InternalException::class);
		$str = '/TestClass';
		$result = Functions::loadClass($pdoMock, $str);
	}

	public function testFunctionsLoadClass4()
	{
		// Creat a fake database connection, because we are working with a test class this connection will never be used.
		// Make maethods prepare and query raise an exception, in case they do get called we are notified.
		$pdoMock = $this->createMock(\PDO::class);
		$pdoMock->method('prepare')
                ->will($this->throwException(new \Exception()));
		$pdoMock->method('query')
                ->will($this->throwException(new \Exception()));

		$this->expectException(InternalException::class);
		$str = '/NonExistingClass/argument';
		$result = Functions::loadClass($pdoMock, $str);
	}

	public function testFunctionsLoadClass5()
	{
		// Creat a fake database connection, because we are working with a test class this connection will never be used.
		// Make maethods prepare and query raise an exception, in case they do get called we are notified.
		$pdoMock = $this->createMock(\PDO::class);
		$pdoMock->method('prepare')
                ->will($this->throwException(new \Exception()));
		$pdoMock->method('query')
                ->will($this->throwException(new \Exception()));

		$this->expectException(InternalException::class);
		$str = '//';
		$result = Functions::loadClass($pdoMock, $str);
	}
}
?>