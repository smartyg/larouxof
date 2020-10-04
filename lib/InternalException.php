<?php

namespace LaRouxOf;

use Exception;

final class InternalException extends Exception
{
/*
1 - page does not exists
2 - product category does not exists
3 - item does not exists
4 - item is not availible anymore
5 - wrong request
5(1) - wrong class name
5(2) - wrong method name
5(3) - wrong argument
6 - internal error
6(1) - can not connect to DB
6(2) - Wrong SQL query
*/
	const _PAGE_NOT_EXIST = 1;
	const _TYPE_NOT_EXIST = 2;
	const _ITEM_NOT_EXIST = 3;
	const _ITEM_NOT_AVAILIBLE = 4;
	const _REQUEST = 5;
	const _INTERNAL = 6;

	const I_PAGE_NOT_EXIST = self::_PAGE_NOT_EXIST | 1 << 4;
	const I_TYPE_NOT_EXIST = self::_TYPE_NOT_EXIST | 1 << 4;
	const I_ITEM_NOT_EXIST = self::_ITEM_NOT_EXIST | 1 << 4;
	const I_ITEM_NOT_AVAILIBLE = self::_ITEM_NOT_AVAILIBLE | 1 << 4;
	const I_CLASSNAME = self::_REQUEST | 1 << 4;
	const I_METHODNAME = self::_REQUEST | 1 << 4;
	const I_ARGUMENTS = self::_REQUEST | 1 << 4;
	const I_NO_DB = self::_INTERNAL | 1 << 4;
	const I_QUERY = self::_INTERNAL | 2 << 4;
	const I_PARENT_NOT_CALLED = self::_INTERNAL | 3 << 4;
	const I_UNKNOWN = self::_INTERNAL | 4 << 4;

	private int $internal_code;

	public function __construct(int $code, string $message, ?Exception $previous = null)
	{
		parent::__construct($message, $code & ((1 << 4) - 1), $previous);
		$this->internal_code = $code >> 4;
	}
}

?>