<?php
namespace LaRouxOf\Test;

require_once __DIR__ . "/../autoloader.php"

use Symfony\Component\Process\Process;
use GuzzleHttp\Client;

class TestApi extends \PHPUnit\Framework\TestCase
{
	private static $process = null;
	private static $conn = null;

	public static function setUpBeforeClass(): void
	{
		if(self::$process == null)
		{
			self::$process = new Process("php -S localhost:8080 -t ./src/");
			self::$process->start();
		}
		if(self::$conn == null) self::$conn = new DatabaseTester();

		usleep(100000); //wait for server to get going
	}

	protected function setUp(): void
	{
		self::$conn->loadCSVTable('pages', __DIR__ . "/../data-sets/pagesSet1.csv");
	}

	protected function tearDown(): void
	{
		self::$conn->clear();
	}

	public static function tearDownAfterClass(): void
	{
		self::$process->stop();
		self::$conn->close();
		self::$conn = null;
	}

	public function testApiPageGetTitle()
	{
		$client = new Client(['http_errors' => false]);

		$response = $client->request("GET", "http://localhost:8080/api/Page/Welcome/getTitle");
		// assert that title is returned
	}

	public function testApiFail0()
	{
		$client = new Client(['http_errors' => false]);

		$response = $client->request("GET", "http://localhost:8080/api/false/Welcome/getTitle");
		// assert that error 404 is returned
	}

	public function testApiFail1()
	{
		$client = new Client(['http_errors' => false]);

		$response = $client->request("GET", "http://localhost:8080/api/PageId/false/getTitle");
		// assert that error 404 is returned
	}
}
?>