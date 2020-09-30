<?php

namespace LaRouxOf;

use PDO;

final class ItemId
{
	public static function loadItemId(PDO $connection, string $id): Page
	{
		return Item::loadById($connection, $id);
	}
}

?>