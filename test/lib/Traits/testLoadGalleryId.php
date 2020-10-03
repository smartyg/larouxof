<?php

namespace LaRouxOf\Test\Traits;

use LaRouxOf\Functions;

trait testLoadGallaryId
{
	abstract protected static function getDB();

	public function testAPIInit()
	{
		$call[] = 'GallaryId';
		$call[] = '2';
		$call[] = 'getTitle';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
		$this->assertEquals('Shoes', $result);
	}

	public function testAPIInit2()
	{
		$call[] = 'GallaryId';
		$call[] = '3';
		$call[] = 'getLink';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
		$this->assertEquals('Gallary/Bags', $result);
	}

	public function testAPIInvalidCall1()
	{
		$call[] = 'GallaryId';
		$call[] = 'InvalidNumber';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);

	}

	public function testAPIInvalidCall2()
	{
		$call[] = 'GallaryId';
		$call[] = '';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testAPIInvalidCall3()
	{
		$call[] = 'GallaryId';
		$call[] = 'null';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testAPIInvalidCall4()
	{
		$call[] = 'GallaryId';
		$call[] = 'false';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testAPIInvalidCall5()
	{
		$call[] = 'GallaryId';
		$call[] = 'true';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}
}

?>