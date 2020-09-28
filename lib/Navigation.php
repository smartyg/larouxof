<?php

namespace LaRouxOf;

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
			echo "\nPDO error: " . $connection->errorCode() . "\n" . $connection->errorInfo()[2];
		}
		foreach($result as $p)
		{
			array_push($this->pages, new $p['category']($p['id'], $p['title'], $p['link']));
		}
	}

	public function getNavigation(): array
	{
		return $this->pages;
	}
}

?>