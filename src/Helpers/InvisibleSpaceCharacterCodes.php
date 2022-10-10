<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Helpers;

abstract class InvisibleSpaceCharacterCodes
{

	/**
	 * @var array<int>
	 */
	private static array $codes = [
		0x9,
		0xA,
		0xB,
		0xC,
		0xD,
		0x20,
		0x85,
		0xA0,
		0x1680,
		0x2000,
		0x2001,
		0x2002,
		0x2003,
		0x2004,
		0x2005,
		0x2006,
		0x2007,
		0x2008,
		0x2009,
		0x200A,
		0x3000,
		0xAD,
		0xF0,
		0xC2AD,
		0xCA,
		0xC2,
	];

	/**
	 * @return array<int>
	 */
	final public static function getCodes(): array
	{
		return self::$codes;
	}

}
