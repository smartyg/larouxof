<?php

namespace LaRouxOf;

use PDO;
use Exception;

final class Page implements iWebpage
{
	private string $title;
	private int $id;
	private string $link;
	private PDO $connection;

	function __construct(int $id, string $title, string $link, PDO $connection)
	{
		$this->id = $id;
		$this->title = $title;
		$this->link = $link;
		$this->connection = $connection;
	}

	public function getLink(): string
	{
		$class = substr(static::class, strlen(__NAMESPACE__) + 1);
		$var = $class . '/' . $this->link;
		return $var;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getCategory(): string
	{
		return substr(static::class, strlen(__NAMESPACE__) + 1);
	}

	public function isDynamicLoadable(): bool
	{
		return false;
	}

	public static function loadByUI(PDO $connection, string $link): self
	{
		$path = Functions::splitCall($link);
		if(count($path) != 1) throw new Exception();
		$sql = "SELECT id, title, link FROM pages WHERE category = 'Page' AND link = :link";
		$sth = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		if($sth === false)
		{
			echo "\nPDO error: " . $connection->errorCode() . "\n" . $connection->errorInfo()[2];
		}
		$sth->execute(array(':link' => $path[0]));
		$res = $sth->fetchAll(PDO::FETCH_ASSOC);
		if(count($res) != 1) throw new Exception;
		$instance = new self($res[0]['id'], $res[0]['title'], $res[0]['link'], $connection);
		return $instance;
	}

	public static function loadPage(PDO $connection, string $link): self
	{
		return self::loadByUI($connection, $link);
	}

	public static function loadById(PDO $connection, int $id): self
	{
		$sql = "SELECT id, title, link FROM pages WHERE category = 'Page' AND id = :id";
		$sth = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		if($sth === false)
		{
			echo "\nPDO error: " . $connection->errorCode() . "\n" . $connection->errorInfo()[2];
		}
		$sth->execute(array(':id' => $id));
		$res = $sth->fetchAll(PDO::FETCH_ASSOC);
		if(count($res) != 1) throw new Exception;
		$instance = new self($res[0]['id'], $res[0]['title'], $res[0]['link'], $connection);
		return $instance;
	}

	public function toHTML(): string
	{
		$sql = "SELECT content FROM content WHERE page_id = :id";
		$sth = $this->connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		if($sth === false)
		{
			echo "\nPDO error: " . $connection->errorCode() . "\n" . $connection->errorInfo()[2];
		}
		$sth->execute(array(':id' => $this->id));
		$res = $sth->fetchAll(PDO::FETCH_ASSOC);
		if(count($res) != 1) throw Exception;
		return $res[0]['content'];
	}
}

?>