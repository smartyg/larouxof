<?php

namespace LaRouxOf;

use PDO;

interface iOutput
{
	public static function loadClass(PDO $connection, string $link);
	public function render(): void;
	public function output(): void;
}