<?php

namespace LaRouxOf\Test\Traits;

use LaRouxOf\Functions;

trait testLoadItemId
{
	abstract protected static function getDB();

	public function testAPIInit()
	{
		$call[] = 'ItemId';
		$call[] = '0';
		$call[] = 'getTitle';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
		$this->assertEquals('Bag 1', $result);
	}

	public function testAPIInit2()
	{
		$call[] = 'ItemId';
		$call[] = '1';
		$call[] = 'getLink';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
		$this->assertEquals('Item/Bags/Bag-2', $result);
	}

	public function testAPIInvalidCall1()
	{
		$call[] = 'ItemId';
		$call[] = 'InvalidNumber';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);

	}

	public function testAPIInvalidCall2()
	{
		$call[] = 'ItemId';
		$call[] = '';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testAPIInvalidCall3()
	{
		$call[] = 'ItemId';
		$call[] = 'null';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testAPIInvalidCall4()
	{
		$call[] = 'ItemId';
		$call[] = 'false';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testAPIInvalidCall5()
	{
		$call[] = 'ItemId';
		$call[] = 'true';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}
}

?>