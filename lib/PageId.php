<?php

namespace LaRouxOf;

use PDO;

final class PageId
{
	public static function loadPageId(PDO $connection, string $id): Page
	{
		return Page::loadById($connection, $id);
	}
}

?>