<?php

namespace LaRouxOf\Test\Traits;

use LaRouxOf\Functions;

trait testLoadPageGetLink
{
	abstract protected static function getDB();

	public function testAPIPageGetLink1()
	{
		$call[] = 'Page';
		$call[] = 'Welcome';
		$call[] = 'getLink';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
		$this->assertEquals('Page/Welcome', $result);
	}

	public function testGUIPageGetLink1()
	{
		$call = '/Page/Welcome';
		$class = Functions::loadClass(self::getDB(), $call);
		$result = $class->getLink();
		$this->assertIsString($result);
		$this->assertEquals('Page/Welcome', $result);
	}

	public function testAPIPageGetLink2()
	{
		$call[] = 'Page';
		$call[] = 'Order';
		$call[] = 'getLink';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
		$this->assertEquals('Page/Order', $result);
	}

	public function testGUIPageGetLink2()
	{
		$call = '/Page/Order';
		$class = Functions::loadClass(self::getDB(), $call);
		$result = $class->getLink();
		$this->assertIsString($result);
		$this->assertEquals('Page/Order', $result);
	}
}

?>