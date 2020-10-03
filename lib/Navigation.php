<?php

namespace LaRouxOf;

use PDO;
use PDOException;

final class Navigation
{
	private PDO $connection;
	private array $pages;

	public function __construct(PDO $connection)
	{
		try {
			$this->connection = $connection;
			$sql = "SELECT id, title, category, link FROM pages ORDER BY id";
			$result = $this->connection->query($sql);
			$this->pages = array();
			foreach($result as $p)
			{
				$class = __NAMESPACE__ . '\\' . $p['category'];
				if(class_exists($class))
				{
					$ifaces = class_implements($class);
					if(isset($ifaces['LaRouxOf\iNavigable']))
						array_push($this->pages, new $class($p['id'], $p['title'], $p['link'], $connection));
				}
			}
		}
		catch (PDOException $e) {
			throw new InternalException(InternalException::I_QUERY, "PDO failed", $e);
		}
	}

	public function getNavigation(): array
	{
		return $this->pages;
	}
}

?>