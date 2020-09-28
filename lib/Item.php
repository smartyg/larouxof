<?php

namespace LaRouxOf;

use PDO;

final class Item implements iLinkable
{
	private int $id;
	private string $name;
	private string $short_description;
	private string $long_description;
	private float $price;
	private string $image_reference;
	private string $link;
	private string $page_link;
	private string $page_title;
	private PDO $connection;

	function __construct(array $input, PDO $connection)
	{
		if(!isset($input['id'])) throw Exception;
		if(!isset($input['name'])) throw Exception;
		if(!isset($input['short_description'])) throw Exception;
		if(!isset($input['long_description'])) throw Exception;
		if(!isset($input['price'])) throw Exception;
		if(!isset($input['image_reference'])) throw Exception;
		if(!isset($input['link'])) throw Exception;
		if(!isset($input['page_link'])) throw Exception;
		if(!isset($input['page_title'])) throw Exception;
		$this->id = $input['id'];
		$this->name = $input['name'];
		$this->short_description = $input['short_description'];
		$this->long_description = $input['long_description'];
		$this->price = $input['price'];
		$this->image_reference = $input['image_reference'];
		$this->link = $input['link'];
		$this->page_link = $input['page_link'];
		$this->page_title = $input['page_title'];
		$this->connection = $connection;
	}

	public function getLink(): string
	{
		$var = static::class . '/' . $this->page_link . '/' . $this->link;
		return $var;
	}

	public function getTitle(): string
	{
		return $this->page_title . " &gt; " . $this->name;
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
		$path = Functions::splitCalls($link);
		if(count($path) != 1) throw new Exception();
		return self::loadItem($path[0], $path[1], $connection);
	}

	public static function loadItem(PDO $connection, string $page_link, string $link): self
	{
		$sql = "SELECT items.id as id, items.name as name, short_description, long_description, price, image_reference, item.link as link, pages.link as page_link, pages.title as page_title FROM items INNER JOIN pages ON items.page_id=pages.id WHERE pages.link = :page_link AND items.link = :link";
		$sth = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		if($sth === false)
		{
			echo "\nPDO error: " . $connection->errorCode() . "\n" . $connection->errorInfo()[2];
		}
		$sth->execute(array(':page_link' => $page_link, ':link' => $link));
		$res = $sth->fetchAll(PDO::FETCH_ASSOC);
		if(count($res) != 1) throw Exception;
		$instance = new self($connection, $res[0]);
		return $instance;
	}

	public function toHTML(): string
	{
		$html = "";
		$html .= '<img src="" alt="' . $this->name . '"></img>';
		$html .= '<h2>' . $this->name . '</h2>';
		$html .= '<p class="ordernr">' . $this->id . '</p>';
		$html .= '<p class="price">' . $this->price . '</p>';
		$html .= '<p class="description">' . $this->long_description . '</p>';
		return $html;
	}

	public function getItem(): array
	{
		return array(
			'order_number' => $this->id,
			'name' => $this->name,
			'long_description' => $this->long_description,
			'price' => $this->price,
			'thumbernail' => $this->image_reference,
			'link' => $this->getLink()
		);
	}

	public function getImage(int $number): string
	{
		$sql = "SELECT image_reference FROM images WHERE item_id = :id ORDER BY image_reference LIMIT :start, 1";
		$sth = $this->connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		if($sth === false)
		{
			echo "\nPDO error: " . $connection->errorCode() . "\n" . $connection->errorInfo()[2];
		}
		$sth->execute(array(':id' => $id, ':start' => $number));
		$res = $sth->fetchAll(PDO::FETCH_ASSOC);
		if(count($res) != 1) throw new Exception();
		return $res[0]['image_reference'];
	}

	public function getPrice(): float
	{
		return $this->price;
	}

	public function getNumOfImage(): int
	{
		$sql = "SELECT count(image_reference) as number FROM images WHERE item_id = :id";
		$sth = $this->connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		if($sth === false)
		{
			echo "\nPDO error: " . $connection->errorCode() . "\n" . $connection->errorInfo()[2];
		}
		$sth->execute(array(':id' => $id));
		$res = $sth->fetchAll(PDO::FETCH_ASSOC);
		if(count($res) != 1) throw new Exception();
		return $res[0]['number'];
	}

	public function getId(): int
	{
		return $this->id;
	}
}

?>