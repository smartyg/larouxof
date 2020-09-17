<?php
namespace LaRouxOf\Test;

require __DIR__ . "/../../vendor/autoload.php";
#require __DIR__ . "/../../src/settings.php";
require __DIR__ . "/../../src/classes/iLinkable.php";
require __DIR__ . "/../../src/classes/iWebpage.php";
require __DIR__ . "/../../src/classes/Page.php";
require __DIR__ . "/../../src/classes/Galary.php";
require __DIR__ . "/../../src/classes/Item.php";
require __DIR__ . "/../../src/classes/Database.php";
require __DIR__ . "/../../src/classes/Functions.php";

require __DIR__ . "/FunctionsClass.php";

use LaRouxOf\Functions;
#use LaRouxOf\TestClass;
use LaRouxOf\Page;

class TestFunctions extends \PHPUnit\Framework\TestCase
{
	public function testFunctionsSplitCall1()
	{
		$str = '/one-root';
		$num_expect = 1;
		$expect[] = 'one-root';

		$result = Functions::splitCall($str);

		$this->assertIsArray($result);
		$this->assertCount($num_expect, $result);
		$this->assertEquals($expect, $result);
	}

	public function testFunctionsSplitCall2()
	{
		$str = '/one-root/two-element';
		$num_expect = 2;
		$expect[] = 'one-root';
		$expect[] = 'two-element';

		$result = Functions::splitCall($str);

		$this->assertIsArray($result);
		$this->assertCount($num_expect, $result);
		$this->assertEquals($expect, $result);
	}

	public function testFunctionsSplitCall3()
	{
		$str = 'one-root';
		$num_expect = 1;
		$expect[] = 'one-root';

		$result = Functions::splitCall($str);

		$this->assertIsArray($result);
		$this->assertCount($num_expect, $result);
		$this->assertEquals($expect, $result);
	}

	public function testFunctionsSplitCall4()
	{
		$str = 'one-root/two-element';
		$num_expect = 2;
		$expect[] = 'one-root';
		$expect[] = 'two-element';

		$result = Functions::splitCall($str);

		$this->assertIsArray($result);
		$this->assertCount($num_expect, $result);
		$this->assertEquals($expect, $result);
	}

	public function testFunctionsSplitCall5()
	{
		$str = '/one-root//two-element';
		$num_expect = 3;
		$expect[] = 'one-root';
		$expect[] = '';
		$expect[] = 'two-element';

		$result = Functions::splitCall($str);

		$this->assertIsArray($result);
		$this->assertCount($num_expect, $result);
		$this->assertEquals($expect, $result);
	}

	public function testFunctionsSplitCall6()
	{
		$str = '/one-root/two-element/';
		$num_expect = 2;
		$expect[] = 'one-root';
		$expect[] = 'two-element';

		$result = Functions::splitCall($str);

		$this->assertIsArray($result);
		$this->assertCount($num_expect, $result);
		$this->assertEquals($expect, $result);
	}

	public function testFunctionsSplitCall7()
	{
		$str = '';
		$num_expect = 0;

		$result = Functions::splitCall($str);

		$this->assertIsArray($result);
		$this->assertCount($num_expect, $result);
		$this->assertEmpty($result);
	}

	public function testFunctionsSplitCall8()
	{
		$str = '/';
		$num_expect = 0;

		$result = Functions::splitCall($str);

		$this->assertIsArray($result);
		$this->assertCount($num_expect, $result);
		$this->assertEmpty($result);
	}

	public function testFunctionsSplitCall9()
	{
		$str = '//';
		$num_expect = 1;
		$expect[] = '';

		$result = Functions::splitCall($str);

		$this->assertIsArray($result);
		$this->assertCount($num_expect, $result);
		$this->assertEquals($expect, $result);
	}

	public function testFunctionsExecuteCall1()
	{
		$expect[] = 'TestClass';
		$expect[] = 'test';
		$expect[] = 'concatenate';
		$expect[] = 'String';
		$result = Functions::executeCall($expect);

		$this->assertIsString($result);
		$this->assertEquals($expect[1] . $expect[3], $result);
	}

	public function testFunctionsLoadClass1()
	{
		$str = '/TestClass/test';
		$result = Functions::loadClass($str);
		$expect = 'test';

		$this->assertIsObject($result);
		$this->assertEquals('LaRouxOf\TestClass', get_class($result));
		$this->assertEquals($expect, $result->toHTML());
	}

	public function testFunctionsLoadClass2()
	{
		$str = '/Page/test';
		$result = Functions::loadClass($str);
		$expect = 'test';

		$this->assertIsObject($result);
		$this->assertEquals('LaRouxOf\Page', get_class($result));
		$this->assertEquals($expect, $result->toHTML());
	}
}
?>