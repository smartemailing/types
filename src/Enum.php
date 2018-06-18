<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Enum\InvalidEnumValueException;

abstract class Enum extends \Consistence\Enum\Enum
{

	/**
	 * @param mixed $value
	 */
	public static function checkValue($value): void
	{
		try {
			parent::checkValue($value);
		} catch (InvalidEnumValueException $e) {
			throw new InvalidTypeException($e->getMessage());
		}
	}

}
