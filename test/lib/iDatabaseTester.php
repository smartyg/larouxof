<?php

namespace LaRouxOf\Test;

use PDO;

interface iDatabaseTester
{
    public function __construct();

    public function getPDO(): PDO;

    public function close(): void;

    //public function loadFile(string $file): void;
}
?>