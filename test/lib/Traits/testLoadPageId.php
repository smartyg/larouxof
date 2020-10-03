<?php

namespace LaRouxOf\Test\Traits;

use LaRouxOf\Functions;

trait testLoadPageId
{
	abstract protected static function getDB();

	public function testAPIPageIdInit()
	{
		$call[] = 'PageId';
		$call[] = '0';
		$call[] = 'getTitle';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
		$this->assertEquals('Welcome', $result);
	}

	public function testAPIPageIdInit2()
	{
		$call[] = 'PageId';
		$call[] = '1';
		$call[] = 'getLink';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
		$this->assertEquals('Page/Order', $result);
	}

	public function testAPIPageIdInvalidCall1()
	{
		$call[] = 'PageId';
		$call[] = 'InvalidNumber';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_REQUEST);
		Functions::executeCall(self::getDB(), $call);

	}

	public function testAPIPageIdInvalidCall2()
	{
		$call[] = 'PageId';
		$call[] = '';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testAPIPageIdInvalidCall3()
	{
		$call[] = 'PageId';
		$call[] = 'null';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testAPIPageIdInvalidCall4()
	{
		$call[] = 'PageId';
		$call[] = 'false';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testAPIPageIdInvalidCall5()
	{
		$call[] = 'PageId';
		$call[] = 'true';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}
}

?>