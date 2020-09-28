<?php

namespace LaRouxOf;

use PDO;

final class Page implements iWebpage
{
	private string $title;
	private int $id;
	private string $link;
	private PDO $connection;

	function __construct(int $id, string $title, string $link, $connection)
	{
		$this->id = $id;
		$this->title = $title;
		$this->link = $link;
		$this->connection = $connection;
	}

	public function getLink(): string
	{
		$var = static::class . '/' . $this->link;
		return $var;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getCategory(): string
	{
		return static::class;
	}

	public function isDynamicLoadable(): bool
	{
		return false;
	}

	public static function loadByUI(PDO $connection, string $link): self
	{
		$path = Functions::splitCall($link);
		if(count($path) != 1) throw new Exception();
		$sql = "SELECT id, title, link FROM pages WHERE category = 'Page' AND link_name = :link";
		$sth = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':link' => $path[0]));
		$res = $sth->fetchAll(PDO::FETCH_ASSOC);
		if(count($res) != 1) throw Exception;
		$instance = new self($res[0]['id'], $res[0]['title'], $res[0]['link'], $connection);
		return $instance;
	}

	public static function loadPage(PDO $connection, string $link): self
	{
		return self::loadByUI($connection, $link);
	}

	public function toHTML(): string
	{
		$sql = "SELECT content FROM content WHERE page_id = :id";
		$sth = $this->connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':id' => $this->id));
		$res = $sth->fetchAll(PDO::FETCH_ASSOC);
		if(count($res) != 1) throw Exception;
		return $res[0]['content'];
	}
}

?>