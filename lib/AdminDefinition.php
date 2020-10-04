<?php

namespace LaRouxOf;

class AdminDefinition
{
	// First 4 bit define the field type
	const _NO_EDIT = 0;
	const _STRING = 1;
	const _INTEGER = 2;
	const _DECIMAL = 3;
	const _TEXT = 4;
	const _WYSIWYG = 5;
	const _IMAGE = 6;
	const _DATE = 7;
	const _BOOL = 8;
	const _OPTIONS = 9;
	const _TIME = 10;
	const _MULTIPLE_IMAGES = 11;
	// Options
	const _REQUIRED = 1 << 4;
	const _HIDDEN = 1 << 5;
	const _FILTERABLE = 1 << 6;
	const _EXTENDED = 1 << 7;

	const DATA_TYPE_SIZE = 4;
	const MASK_DATA_TYPE = (1 << self::DATA_TYPE_SIZE) - 1;
	const MASK_OPTIONS = ~ self::MASK_DATA_TYPE;

	private array $definition = [];

	public function __construct()
	{
	}

	public function addField(string $name, int $type): self
	{
		$this->definition[] = array('name' => $name, 'type' => $type);
		return $this;
	}

	public function getDefinition(): array
	{
		return $this->definition;
	}
}

?>