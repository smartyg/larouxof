<?php

namespace LaRouxOf;

class TestClass implements iWebpage
{
	private string $link;

	function __construct(string $link)
	{
		$this->link = $link;
	}

	public function getLink(): string
	{
		return $this->link;
	}

	public function getTitle(): string
	{
		return $this->link;
	}

	public function getCategory(): string
	{
		return $this->link;
	}

	public function isDynamicLoadable(): bool
	{
		return true;
	}

	public static function loadByUI(string $link): self
	{
		return new self($link);
	}

	public static function loadTestClass(string $link): self
	{
		return self::loadByUI($link);
	}

	public function toHTML(): string
	{
		return $this->link;
	}

	public function concatenate(string $part2): string
	{
		return $this->link . $part2;
	}
}

?>