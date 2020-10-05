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
	private array $definitionJS = [];

	public function __construct()
	{
	}

	public function addField(string $name, int $type, ?string $hint = null, ?string $tooltip = null): self
	{
		$this->definition[] = array('name' => $name, 'type' => $type, 'hint' => $hint, 'tooltip' => $tooltip);
		$this->definitionJS[$name] = array('name' => $name, 'type' => $type, 'hint' => $hint, 'tooltip' => $tooltip);
		return $this;
	}

	public function getDefinition(): array
	{
		return $this->definition;
	}

	public function getDefinitionJS(): array
	{
		return $this->definitionJS;
	}

	public function __toString(): string
	{
		return json_encode($this->definitionJS);
	}
}

?>