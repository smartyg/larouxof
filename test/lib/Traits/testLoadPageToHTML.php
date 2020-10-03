<?php

namespace LaRouxOf\Test\Traits;

use LaRouxOf\Functions;

trait testLoadPageToHTML
{
	abstract protected static function getDB();

	public function testAPIToHTML1()
	{
		$call[] = 'Page';
		$call[] = 'Welcome';
		$call[] = 'toHTML';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
	}

	public function testGUIToHTML1()
	{
		$call = '/Page/Welcome';
		$class = Functions::loadClass(self::getDB(), $call);
		$result = $class->toHTML();
		$this->assertIsString($result);
	}

	public function testAPIToHTML2()
	{
		$call[] = 'Page';
		$call[] = 'Order';
		$call[] = 'toHTML';
		$result = Functions::executeCall(self::getDB(), $call);
		$this->assertIsString($result);
	}

	public function testGUIToHTML2()
	{
		$call = '/Page/Order';
		$class = Functions::loadClass(self::getDB(), $call);
		$result = $class->toHTML();
		$this->assertIsString($result);
	}
}

?>