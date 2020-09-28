<?php

namespace LaRouxOf;

use PDO;

final class Galery implements iWebpage
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

	public static function loadByUI(PDO $connection, string $link): self
	{
		$path = Functions::splitCalls($link);
		if(count($path) != 1) throw new Exception();
		$sql = "SELECT id, title, link FROM pages WHERE category = 'Galary' AND link_name = :link";
		$sth = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		if($sth === false)
		{
			echo "\nPDO error: " . $connection->errorCode() . "\n" . $connection->errorInfo()[2];
		}
		$sth->execute(array(':link' => $path[0]));
		$res = $sth->fetchAll(PDO::FETCH_ASSOC);
		if(count($res) != 1) throw Exception;
		$instance = new self($res[0]['id'], $res[0]['title'], $res[0]['link'], $connection);
		return $instance;
	}

	public static function loadGalery(PDO $connection, string $link): self
	{
		return self::loadByUI($connection, $link);
	}

	public function toHTML(): string
	{
		return "";
	}

	public function loadItems(int $start = 0, int $number = 10, string $sort = "id", string $order = "ASC"): ?array
	{
		if(!in_array($sort, array('id', 'name', 'price'))) $sort = 'id';
		if(!in_array($order, array('ASC', 'DESC'))) $order = 'ASC';

		$sql = "SELECT id, name, short_description, price, image_reference, link FROM items WHERE page_id = :p_id ORDER BY :column :order LIMIT :start, :number";
		$sth = $this->connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':p_id' => $this->id, ':start' => $start, ':number' => $number, ':column' => $sort, ':order' => $order));
		if($sth === false)
		{
			echo "\nPDO error: " . $connection->errorCode() . "\n" . $connection->errorInfo()[2];
		}
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