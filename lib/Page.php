<?php

namespace LaRouxOf;

use PDO;
use PDOException;

final class Page extends baseWebpage implements iNavigable, iApi, iAdmin
{
	private string $title;
	private int $id;
	private string $link;

	public function __construct(int $id, string $title, string $link, PDO $connection)
	{
		$this->id = $id;
		$this->title = $title;
		$this->link = $link;
		$this->connection = $connection;
	}

	public static function getName(): string
	{
		$class = substr(static::class, strlen(__NAMESPACE__) + 1);
		return '/' . $class;
	}

	public function getLink(): string
	{
		return '/' . self::getName() . '/' . $this->link;
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

	public static function apiMethods(): array
	{
		return array();
	}

	public static function loadClass(PDO $connection, string $link): self
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
		return self::loadClass($connection, $link);
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

	public function getContent(): string
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

	public static function apiAdminMethods(): array
	{
		return array_merge(self::apiMethods(), array('loadEditRecords', 'newRecord', 'changeRecord'));
	}

	public static function getAdminFields(): AdminDefinition
	{
		return (new AdminDefinition())
			->addField('id', AdminDefinition::_NO_EDIT | AdminDefinition::_HIDDEN)
			->addField('title', AdminDefinition::_STRING | AdminDefinition::_REQUIRED | AdminDefinition::_FILTERABLE)
			->addField('content', AdminDefinition::_WYSIWYG | AdminDefinition::_REQUIRED | AdminDefinition::_EXTENDED);
	}

	public static function loadEditRecords(PDO $connection): array
	{
		try {
			$sql = "SELECT id, title, link, content.content as content FROM pages LEFT JOIN content ON pages.id = content.page_id WHERE category = 'Page'";
			$sth = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$sth->execute();
			$res = $sth->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		catch (PDOException $e) {
			throw new InternalException(InternalException::I_QUERY, "PDO failed", $e);
		}
	}

	public static function newRecord(PDO $connection, array $record): bool
	{
		return true;
	}

	public static function changeRecord(PDO $connection, array $record): bool
	{
		return true;
	}
}

?>