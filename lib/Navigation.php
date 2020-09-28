<?php

namespace LaRouxOf;

use PDO;

final class Navigation
{
	private PDO $connection;
	private array $pages;

	function __construct(PDO $connection)
	{
		$this->connection = $connection;
		$sql = "SELECT id, title, category, link FROM pages ORDER BY id";
		$result = $this->connection->query($sql);
		if($result === false)
		{
			echo "\nPDO error: " . $this->connection->errorCode() . "\n" . $this->connection->errorInfo()[2];
		}
		$this->pages = array();
		foreach($result as $p)
		{
			$class = __NAMESPACE__ . '\\' . $p['category'];
			array_push($this->pages, new $class($p['id'], $p['title'], $p['link'], $connection));
		}
	}

	public function getNavigation(): array
	{
		return $this->pages;
	}
}

?>