<?php

namespace LaRouxOf;

use PDO;

interface iWebpage extends iLinkable
{
	public function getTitle(): string;
	public function getCategory(): string;
	public function isDynamicLoadable(): bool;
}

?>