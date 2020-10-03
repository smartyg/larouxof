<?php

namespace LaRouxOf\Test\Traits;

use LaRouxOf\Functions;

trait testLoadItem
{
	abstract protected static function getDB();

	public function testAPIInit()
	{
		$call[] = 'Item';
		$call[] = 'Bags';
		$call[] = 'Bag-1';
		$call[] = 'getTitle';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
	}

	public function testGUIInit()
	{
		$call = '/Item/Bags/Bag-1';
		$result = Functions::loadPage(self::getDB(), $call);
		$this->assertIsObject($result);
		$this->assertInstanceOf(\LaRouxOf\Item::class, $result);
	}

	public function testGUIInit2()
	{
		$call = '/Item/Bags/Bag-1/';
		$result = Functions::loadPage(self::getDB(), $call);
		$this->assertIsObject($result);
		$this->assertInstanceOf(\LaRouxOf\Item::class, $result);
	}

	public function testAPIInvalidCall1()
	{
		$call[] = 'Item';
		$call[] = 'Bags';
		$call[] = '';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);

	}

	public function testGUIInvalidCall1()
	{
		$call = '/Item/Bags//';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::loadPage(self::getDB(), $call);
	}

	public function testAPIInvalidCall2()
	{
		$call[] = 'Item';
		$call[] = 'Bags';
		$call[] = '0';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testGUIInvalidCall2()
	{
		$call = '/Item/Bags/0';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::loadPage(self::getDB(), $call);
	}

	public function testAPIInvalidCall3()
	{
		$call[] = 'Item';
		$call[] = 'Bags';
		$call[] = 'null';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testGUIInvalidCall3()
	{
		$call = '/Item/Bags/null';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::loadPage(self::getDB(), $call);
	}

	public function testAPIInvalidCall4()
	{
		$call[] = 'Item';
		$call[] = 'Bags';
		$call[] = 'false';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testGUIInvalidCall4()
	{
		$call = '/Item/Bags/false';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::loadPage(self::getDB(), $call);
	}

	public function testAPIInvalidCall5()
	{
		$call[] = 'Item';
		$call[] = 'Bags';
		$call[] = 'true';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testGUIInvalidCall5()
	{
		$call = '/Item/Bags/true';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::loadPage(self::getDB(), $call);
	}

	public function testAPIInvalidCall6()
	{
		$call[] = 'Item';
		$call[] = '';
		$call[] = 'Bag-1';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);

	}

	public function testGUIInvalidCall6()
	{
		$call = '/Item//Bag-1';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::loadPage(self::getDB(), $call);
	}

	public function testAPIInvalidCall7()
	{
		$call[] = 'Item';
		$call[] = '0';
		$call[] = 'Bag-1';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testGUIInvalidCall7()
	{
		$call = '/Item/0/Bag-1';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::loadPage(self::getDB(), $call);
	}

	public function testAPIInvalidCall8()
	{
		$call[] = 'Item';
		$call[] = 'null';
		$call[] = 'Bag-1';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testGUIInvalidCall8()
	{
		$call = '/Item/null/Bag-1';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::loadPage(self::getDB(), $call);
	}

	public function testAPIInvalidCall9()
	{
		$call[] = 'Item';
		$call[] = 'false';
		$call[] = 'Bag-1';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testGUIInvalidCall9()
	{
		$call = '/Item/false/Bags-1';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::loadPage(self::getDB(), $call);
	}

	public function testAPIInvalidCall10()
	{
		$call[] = 'Item';
		$call[] = 'true';
		$call[] = 'Bag-1';
		$call[] = 'getTitle';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::executeCall(self::getDB(), $call);
	}

	public function testGUIInvalidCall10()
	{
		$call = '/Item/true/Bag-1';
		$this->expectException(\LaRouxOf\InternalException::class);
		$this->expectExceptionCode(\LaRouxOf\InternalException::_E_REQUEST);
		Functions::loadPage(self::getDB(), $call);
	}
}

?>