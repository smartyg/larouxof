<?php

namespace LaRouxOf\Test\Traits;

use LaRouxOf\Functions;

trait testLoadPageGetTitle
{
	abstract protected static function getDB();

	public function testAPIPageGetTitle1()
	{
		$call[] = 'Page';
		$call[] = 'Welcome';
		$call[] = 'getTitle';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
		$this->assertEquals('Welcome', $result);
	}

	public function testGUIPageGetTitle1()
	{
		$call = '/Page/Welcome';
		$class = Functions::loadClass(self::getDB(), $call);
		$result = $class->getTitle();
		$this->assertIsString($result);
		$this->assertEquals('Welcome', $result);
	}

	public function testAPIPageGetTitle2()
	{
		$call[] = 'Page';
		$call[] = 'Order';
		$call[] = 'getTitle';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
		$this->assertEquals('Order', $result);
	}

	public function testGUIPageGetTitle2()
	{
		$call = '/Page/Order';
		$class = Functions::loadClass(self::getDB(), $call);
		$result = $class->getTitle();
		$this->assertIsString($result);
		$this->assertEquals('Order', $result);
	}
}

?>