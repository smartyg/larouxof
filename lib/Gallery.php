<?php

namespace LaRouxOf;

use PDO;
use PDOException;

final class Gallery implements iWebpage, iNavigable
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
		return static::class;
	}

	public function isDynamicLoadable(): bool
	{
		return true;
	}

	public static function loadByUI(PDO $connection, string $link): self
	{
		try {
			$path = Functions::splitCall($link);
			if(count($path) != 1) throw new InternalException(InternalException::I_ARGUMENTS, self::class . ' requires one argument, ' . $count($path) . ' are given.');
			$sql = "SELECT id, title, link FROM pages WHERE category = 'Gallery' AND link = :link";
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

	public static function loadGallery(PDO $connection, string $link): self
	{
		return self::loadByUI($connection, $link);
	}

	public function toHTML(): string
	{
		$html = '<div class="button top">';
		$html .= '<select name="sort" id="sort">';
		$html .= '<option value="price">Price</option><option value="name">Name</option><option value="id">order #</option>';
		$html .= '</select>';
		$html .= '<div class="sorting">';
		$html .= '<svg class="arrow-up"><polygon class="link" points="2,9 9,2 16,9"/></svg>';
		$html .= '<svg class="arrow-down"><polygon class="link" points="2,2 9,9 16,2"/></svg>';
		$html .= '</div>';
		$html .= '<svg class="view-switch link">';
		$html .= '<circle class="list-view" cx="3" cy="4" r="2"></circle>';
		$html .= '<circle class="list-view" cx="3" cy="12" r="2"></circle>';
		$html .= '<circle class="list-view" cx="3" cy="19" r="2"></circle>';
		$html .= '<line class="list-view" x1="7" y1="5" x2="24" y2="5"></line>';
		$html .= '<line class="list-view" x1="7" y1="13" x2="24" y2="13"></line>';
		$html .= '<line class="list-view" x1="7" y1="20" x2="24" y2="20"></line>';
		$html .= '<rect class="grid-view nodisplay" x="2" y="2" rx="1" ry="1" width="8" height="8"></rect>';
		$html .= '<rect class="grid-view nodisplay" x="15" y="2" rx="1" ry="1" width="8" height="8"></rect>';
		$html .= '<rect class="grid-view nodisplay" x="2" y="15" rx="1" ry="1" width="8" height="8"></rect>';
		$html .= '<rect class="grid-view nodisplay" x="15" y="15" rx="1" ry="1" width="8" height="8"></rect>';
		$html .= '</svg>';
		$html .= '</div>';
		return $html;
	}

	public function loadItems(int $start = 0, int $number = 10, string $sort = "id", string $order = "ASC"): ?array
	{
		if(!in_array($sort, array('id', 'name', 'price'))) $sort = 'id';
		if(!in_array($order, array('ASC', 'DESC'))) $order = 'ASC';

		try {
			$sql = "SELECT id, name, short_description, price, image_reference, link FROM items WHERE page_id = :p_id ORDER BY :column :order LIMIT :start, :number";
			$sth = $this->connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$sth->execute(array(':p_id' => $this->id, ':start' => $start, ':number' => $number, ':column' => $sort, ':order' => $order));
			$res = $sth->fetchAll(PDO::FETCH_ASSOC);
			if(count($res) > $number) throw InternalException(InternalException::I_QUERY, 'Query for items returned too many results.');
			if(count($res) == 0) return null;
			$items = array();
			foreach($res as $row)
			{
				array_push($items, new Item($row));
			}
			return $items;
		}
		catch (PDOException $e) {
			throw new InternalException(InternalException::I_QUERY, "PDO failed", $e);
		}
	}
}

?>