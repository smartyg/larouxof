<?php

namespace LaRouxOf\Test\Traits;

use LaRouxOf\Functions;

trait testLoadPageGetCategory
{
	abstract protected static function getDB();

	public function testAPIPageGetCategory1()
	{
		$call[] = 'Page';
		$call[] = 'Welcome';
		$call[] = 'getCategory';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
		$this->assertEquals('Page', $result);
	}

	public function testGUIPageGetCategory1()
	{
		$call = '/Page/Welcome';
		$class = Functions::loadClass(self::getDB(), $call);
		$result = $class->getCategory();
		$this->assertIsString($result);
		$this->assertEquals('Page', $result);
	}

	public function testAPIPageGetCategory2()
	{
		$call[] = 'Page';
		$call[] = 'Order';
		$call[] = 'getCategory';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
		$this->assertEquals('Page', $result);
	}

	public function testGUIPageGetCategory2()
	{
		$call = '/Page/Order';
		$class = Functions::loadClass(self::getDB(), $call);
		$result = $class->getCategory();
		$this->assertIsString($result);
		$this->assertEquals('Page', $result);
	}
}

?>