<?php

namespace LaRouxOf;

use PDO;
use PDOException;

final class Page implements iWebpage, iNavigable
{
	private string $title;
	private int $id;
	private string $link;
	private PDO $connection;

	public function __construct(int $id, string $title, string $link, PDO $connection)
	{
		$this->id = $id;
		$this->title = $title;
		$this->link = $link;
		$this->connection = $connection;
	}

	public function getLink(): string
	{
		$class = substr(static::class, strlen(__NAMESPACE__) + 1);
		return '/' . $class . '/' . $this->link;
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
		try {
			$path = Functions::splitCall($link);
			if(count($path) != 1) throw new InternalException(InternalException::I_ARGUMENTS, self::class . ' requires one argument, ' . $count($path) . ' are given.');
			$sql = "SELECT id, title, link FROM pages WHERE category = 'Page' AND link = :link";
			$sth = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$sth->execute(array(':link' => $path[0]));
			$res = $sth->fetchAll(PDO::FETCH_ASSOC);
			if(count($res) == 0) throw new InternalException(InternalException::I_PAGE_NOT_EXIST, 'Page with the name ' . $path[0] . ' does not exists.');
			elseif(count($res) > 1) throw new InternalException(InternalException::I_QUERY, 'Query for page ' . $path[0] . ' returned too many results.');
			$instance = new self($res[0]['id'], $res[0]['title'], $res[0]['link'], $connection);
			return $instance;
		}
		catch (PDOException $e) {
			throw new InternalException(InternalException::I_QUERY, "PDO failed", $e);
		}
	}

	public static function loadPage(PDO $connection, string $link): self
	{
		return self::loadByUI($connection, $link);
	}

	public static function loadById(PDO $connection, int $id): self
	{
		try {
			$sql = "SELECT id, title, link FROM pages WHERE category = 'Page' AND id = :id";
			$sth = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$sth->execute(array(':id' => $id));
			$res = $sth->fetchAll(PDO::FETCH_ASSOC);
			if(count($res) == 0) throw new InternalException(InternalException::I_PAGE_NOT_EXIST, 'Page with the id ' . $id . ' does not exists.');
			elseif(count($res) > 1) throw new InternalException(InternalException::I_QUERY, 'Query for page with id ' . $id . ' returned too many results.');
			$instance = new self($res[0]['id'], $res[0]['title'], $res[0]['link'], $connection);
			return $instance;
		}
		catch (PDOException $e) {
			throw new InternalException(InternalException::I_QUERY, "PDO failed", $e);
		}
	}

	public function toHTML(): string
	{
		try {
			$sql = "SELECT content FROM content WHERE page_id = :id";
			$sth = $this->connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$sth->execute(array(':id' => $this->id));
			$res = $sth->fetchAll(PDO::FETCH_ASSOC);
			if(count($res) == 0) throw new InternalException(InternalException::I_PAGE_NOT_EXIST, 'Page with the id ' . $this->id . ' does not exists.');
			elseif(count($res) > 1) throw new InternalException(InternalException::I_QUERY, 'Query for page with id ' . $this->id . ' returned too many results.');
			return $res[0]['content'];
		}
		catch (PDOException $e) {
			throw new InternalException(InternalException::I_QUERY, "PDO failed", $e);
		}
	}
}

?>