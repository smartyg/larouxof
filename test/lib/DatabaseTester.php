<?php

namespace LaRouxOf\Test;

require_once __DIR__ . "/iDatabaseTester.php";

use PDO;

class DatabaseTester implements iDatabaseTester
{
    // only instantiate pdo once for test clean-up/fixture load
    private ?PDO $conn = null;

    public function __construct()
    {
		$this->conn = new PDO('sqlite::memory:');
    }

    public function getPDO(): PDO
    {
        return $this->conn();
    }

    private static function transform(array $in): array
    {
		$out = array();
		$n = 0;
		foreach($in as $value)
		{
			$key = ':field' . $n;
			$out += [$key => $value];
		}
		return $out;
    }

    public function loadCSVTable(string $name, string $file): void
    {
		$handle = fopen($file, "r");
		$insert_fields = "";
		$firstline = true;
		if ($handle) {
			while (($line = fgets($handle)) !== false) {
				$parts = str_getcsv($line, ',', '"');
				if($firstline)
				{
					$num_columns = count($parts);

					for($n = 0; $n < $num_columns; $n++)
					{
						if($n > 0) $insert_fields .= ',';
						$insert_fields .= ':field' . $n;
					}
					$sql = 'CREATE TABLE ' . $name . ' (' . $insert_fields . ');';
					$insert = self::transform($parts);
					$sth = $this->conn->prepare($sql);
					$sth->execute($insert);

					$firstline = false;
				}
				else
				{
					if(count($parts) != $num_columns)
						throw new Exception();
					$sql = 'INSERT INTO ' . $name . ' VALUES (' . $insert_fields . ');';
					$insert = self::transform($parts);
					$sth = $this->conn->prepare($sql);
					$sth->execute($insert);
				}
			}

			fclose($handle);
		} else {
			// error opening the file.
			throw new Exception();
		}
    }
/*
    final public function assertValue(string $table, string $result_column, string $select_column, string $select_value, $expected_value): void
    {

    }
*/
    public function close(): void
    {
		$this->conn = null;
    }
}
?>