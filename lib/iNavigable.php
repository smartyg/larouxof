<?php

namespace LaRouxOf;

use PDO;

interface iNavigable extends iLinkable
{
	public function __construct(int $id, string $title, string $link, PDO $connection);
}

?>