<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Helpers;

use SmartEmailing\Types\ToFloatInterface;
use SmartEmailing\Types\ToIntInterface;

abstract class NumberHelpers
{

	final public static function getFloatOrNull(?ToFloatInterface $float): ?float
	{
		if ($float === null) {
			return null;
		}

		return $float->getValue();
	}

	final public static function getIntOrNull(?ToIntInterface $int): ?int
	{
		if ($int === null) {
			return null;
		}

		return $int->getValue();
	}

}
