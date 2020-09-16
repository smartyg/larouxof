<?php

final class Navigation
{
	private array $pages;

	function __construct()
	{
		$conn = Database::connect();
		$sql = "SELECT id, title, category, link FROM pages ORDER BY id";
		$result = $conn->query($sql);
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