<?php
namespace LaRouxOf\Test;

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../lib/DatabaseTester.php";

use PDO, PDOStatement;

class TestDatabaseTester extends \PHPUnit\Framework\TestCase
{
	public function testDBLoad()
	{
		$db = new DatabaseTester();
		$db->loadCSVTable('test', __DIR__ . "/../data-sets/databaseTester1.csv");

		$result = $db->getPDO();
		$this->assertIsObject($result);
		$this->assertInstanceOf(PDO::class, $result);
	}

	public function testDBRead()
	{
		$db = new DatabaseTester();
		$db->loadCSVTable('test', __DIR__ . "/../data-sets/databaseTester1.csv");

		$conn = $db->getPDO();
		$this->assertIsObject($conn);
		$this->assertInstanceOf(PDO::class, $conn);

		$sql = 'SELECT * FROM `test`;';
		$result = $conn->query($sql);

		$this->assertIsObject($result);
		$this->assertInstanceOf(PDOStatement::class, $result);
	}

	public function testDBWReadAll()
	{
		$db = new DatabaseTester();
		$db->loadCSVTable('test', __DIR__ . "/../data-sets/databaseTester1.csv");

		$conn = $db->getPDO();
		$this->assertIsObject($conn);
		$this->assertInstanceOf(PDO::class, $conn);

		$sql = 'SELECT * FROM `test`;';
		$sth = $conn->query($sql);

		$this->assertIsObject($sth);
		$this->assertInstanceOf(PDOStatement::class, $sth);

		$result = $sth->fetchAll();

		$this->assertIsArray($result);
		$this->assertEquals(4, count($result));
	}

	public function testDBCount()
	{
		$db = new DatabaseTester();
		$db->loadCSVTable('test', __DIR__ . "/../data-sets/databaseTester1.csv");

		$conn = $db->getPDO();
		$this->assertIsObject($conn);
		$this->assertInstanceOf(PDO::class, $conn);

		$sql = 'SELECT count(id) as result FROM `test`;';
		$sth = $conn->query($sql);

		$this->assertIsObject($sth);
		$this->assertInstanceOf(PDOStatement::class, $sth);

		$result = $sth->fetch();

		$this->assertIsArray($result);
		$this->assertEquals(4, $result['result']);
	}
}
?>