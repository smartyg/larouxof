<?php

namespace LaRouxOf\Test\Traits;

use LaRouxOf\Functions;

trait testLoadGallery
{
	abstract protected static function getDB();

	public function testAPIInit()
	{
		$call[] = 'Gallery';
		$call[] = 'Shoes';
		$call[] = 'getTitle';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
	}

	public function testGUIInit()
	{
		$call = '/Gallery/Shoes';
		$result = Functions::loadPage(self::getDB(), $call);
		$this->assertIsObject($result);
		$this->assertInstanceOf(\LaRouxOf\Gallery::class, $result);
	}

	public function testGUIInit2()
	{
		$call = '/Gallery/Shoes/';
		$result = Functions::loadPage(self::getDB(), $call);
		$this->assertIsObject($result);
		$this->assertInstanceOf(\LaRouxOf\Gallery::class, $result);
	}

	public function testAPIInvalidCall1()
	{
		$call[] = 'Gallery';
		$call[] = '';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);

	}

	public function testGUIInvalidCall1()
	{
		$call = '/Gallery//';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::loadPage(self::getDB(), $call);
	}

	public function testAPIInvalidCall2()
	{
		$call[] = 'Gallery';
		$call[] = '0';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testGUIInvalidCall2()
	{
		$call = '/Gallery/0';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::loadPage(self::getDB(), $call);
	}

	public function testAPIInvalidCall3()
	{
		$call[] = 'Gallery';
		$call[] = 'null';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testGUIInvalidCall3()
	{
		$call = '/Gallery/null';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::loadPage(self::getDB(), $call);
	}

	public function testAPIInvalidCall4()
	{
		$call[] = 'Gallery';
		$call[] = 'false';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testGUIInvalidCall4()
	{
		$call = '/Gallery/false';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::loadPage(self::getDB(), $call);
	}

	public function testAPIInvalidCall5()
	{
		$call[] = 'Gallery';
		$call[] = 'true';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testGUIInvalidCall5()
	{
		$call = '/Gallery/true';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::loadPage(self::getDB(), $call);
	}
}

?>