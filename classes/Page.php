<?php

final class Page implements iWebpage
{
	private string $title;
	private int $id;
	private string $link;

	function __construct(int $id, string $title, string $link)
	{
		$this->id = $id;
		$this->title = $title;
		$this->link = $link;
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

	public static function loadByUI(string $link): self
	{
		$path = Functions::splitCalls($link);
		if(count($path) != 1) throw new Exception();
		$conn = Database::connect();
		$sql = "SELECT id, title, link FROM pages WHERE category = 'Page' AND link_name = :link";
		$sth = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':link' => $path[0]));
		$res = $sth->fetchAll(PDO::FETCH_ASSOC);
		if(count($res) != 1) throw Exception;
		$instance = new self($res[0]['id'], $res[0]['title'], $res[0]['link']);
		return $instance;
	}

	public static function loadPage(string $link): self
	{
		return self::loadByUI($link);
	}

	public function toHTML(): string
	{
		$conn = Database::connect();
		$sql = "SELECT content FROM content WHERE page_id = :id";
		$sth = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':id' => $this->id));
		$res = $sth->fetchAll(PDO::FETCH_ASSOC);
		if(count($res) != 1) throw Exception;
		return $res[0]['content'];
	}
}

?>