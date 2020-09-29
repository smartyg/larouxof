<?php
namespace LaRouxOf\Test;

require_once __DIR__ . "/../../vendor/autoload.php";
#require_once __DIR__ . "/../../src/settings.php";
require_once __DIR__ . "/../../lib/iLinkable.php";
require_once __DIR__ . "/../../lib/iWebpage.php";
require_once __DIR__ . "/../../lib/Page.php";
require_once __DIR__ . "/../../lib/Gallery.php";
require_once __DIR__ . "/../../lib/Item.php";
require_once __DIR__ . "/../../lib/Database.php";
require_once __DIR__ . "/../../lib/Functions.php";

require_once __DIR__ . "/FunctionsClass.php";

use LaRouxOf\Functions;

class TestFunctionsSplitCall extends \PHPUnit\Framework\TestCase
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
}
?>