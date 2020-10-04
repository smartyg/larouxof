<?php

namespace LaRouxOf;

use PDO;

interface iAdmin extends iApi
{
	public static function getName(): string;
	public static function apiAdminMethods(): array;
	public static function getAdminFields(): AdminDefinition;
	public static function loadEditRecords(PDO $connection): array;
	public static function newRecord(PDO $connection, array $record): bool;
	public static function changeRecord(PDO $connection, array $record): bool;
}

?>