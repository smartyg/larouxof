<?php

namespace LaRouxOf;

final class Galery implements iWebpage
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
		return true;
	}

	public static function loadByUI(string $link): self
	{
		$path = Functions::splitCalls($link);
		if(count($path) != 1) throw new Exception();
		$conn = Database::connect();
		$sql = "SELECT id, title, link FROM pages WHERE category = 'Galary' AND link_name = :link";
		$sth = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':link' => $path[0]));
		$res = $sth->fetchAll(PDO::FETCH_ASSOC);
		if(count($res) != 1) throw Exception;
		$instance = new self($res[0]['id'], $res[0]['title'], $res[0]['link']);
		return $instance;
	}

	public static function loadGalery(string $link): self
	{
		return self::loadByUI($link);
	}

	public function toHTML(): string
	{
		return "";
	}

	public function getItems(int $start, int $number): ?array
	{
		$conn = Database::connect();
		$sql = "SELECT id, name, short_description, price, image_reference, link FROM items WHERE page_id = :p_id ORDER BY id LIMIT :start, :number";
		$sth = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':p_id' => $this->id, ':start' => $start, ':number' => $number));
		$res = $sth->fetchAll(PDO::FETCH_ASSOC);
		if(count($res) > $number) throw Exception;
		if(count($res) == 0) return null;
		$items = array();
		foreach($res as $row)
		{
			array_push($items, new Item($row));

		}
		return $items;
	}
}

?>