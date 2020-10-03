<?php
namespace LaRouxOf\Test\Traits;

use LaRouxOf\Functions;

trait testLoadPageIsDynamicLoadable
{
	abstract protected static function getDB();

	public function testAPIIsDynamicLoadable1()
	{
		$call[] = 'Page';
		$call[] = 'Welcome';
		$call[] = 'isDynamicLoadable';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsBool($result);
		$this->assertEquals(false, $result);
	}

	public function testGUIIsDynamicLoadable1()
	{
		$call = '/Page/Welcome';
		$class = Functions::loadClass(self::getDB(), $call);
		$result = $class->isDynamicLoadable();
		$this->assertIsBool($result);
		$this->assertEquals(false, $result);
	}

	public function testAPIIsDynamicLoadable2()
	{
		$call[] = 'Page';
		$call[] = 'Order';
		$call[] = 'isDynamicLoadable';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsBool($result);
		$this->assertEquals(false, $result);
	}

	public function testGUIIsDynamicLoadable2()
	{
		$call = '/Page/Order';
		$class = Functions::loadClass(self::getDB(), $call);
		$result = $class->isDynamicLoadable();
		$this->assertIsBool($result);
		$this->assertEquals(false, $result);
	}
}

?>