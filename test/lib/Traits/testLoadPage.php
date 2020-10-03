<?php

namespace LaRouxOf\Test\Traits;

use LaRouxOf\Functions;

trait testLoadPage
{
	abstract protected static function getDB();

	public function testAPIPageInit()
	{
		$call[] = 'Page';
		$call[] = 'Welcome';
		$call[] = 'getTitle';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
	}

	public function testGUIInit()
	{
		$call = '/Page/Welcome';
		$result = Functions::loadClass(self::getDB(), $call);
		$this->assertIsObject($result);
		$this->assertInstanceOf(\LaRouxOf\Page::class, $result);
	}

	public function testGUIInit2()
	{
		$call = '/Page/Welcome/';
		$result = Functions::loadClass(self::getDB(), $call);
		$this->assertIsObject($result);
		$this->assertInstanceOf(\LaRouxOf\Page::class, $result);
	}

	public function testAPIPageInvalidCall1()
	{
		$call[] = 'Page';
		$call[] = '';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_REQUEST);
		Functions::executeCall(self::getDB(), $call);

	}

	public function testGUIInvalidCall1()
	{
		$call = '/Page//';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_REQUEST);
		Functions::loadClass(self::getDB(), $call);
	}

	public function testAPIPageInvalidCall2()
	{
		$call[] = 'Page';
		$call[] = '0';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testGUIInvalidCall2()
	{
		$call = '/Page/0';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_REQUEST);
		Functions::loadClass(self::getDB(), $call);
	}

	public function testAPIPageInvalidCall3()
	{
		$call[] = 'Page';
		$call[] = 'null';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testGUIInvalidCall3()
	{
		$call = '/Page/null';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_REQUEST);
		Functions::loadClass(self::getDB(), $call);
	}

	public function testAPIPageInvalidCall4()
	{
		$call[] = 'Page';
		$call[] = 'false';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testGUIInvalidCall4()
	{
		$call = '/Page/false';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_REQUEST);
		Functions::loadClass(self::getDB(), $call);
	}

	public function testAPIPageInvalidCall5()
	{
		$call[] = 'Page';
		$call[] = 'true';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testGUIInvalidCall5()
	{
		$call = '/Page/true';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_REQUEST);
		Functions::loadClass(self::getDB(), $call);
	}
}

?>