<?php

namespace LaRouxOf;

use PDO;

interface iWebpage extends iLinkable
{
	public function getTitle(): string;
	public function getCategory(): string;
	public function isDynamicLoadable(): bool;
	public function toHTML(): string;
	public static function loadByUI(PDO $connection, string $link);
}

?>