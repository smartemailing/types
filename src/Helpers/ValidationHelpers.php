<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Helpers;

use Consistence\Type\ObjectMixinTrait;

abstract class ValidationHelpers
{

	use ObjectMixinTrait;

	/**
	 * @param mixed[] $array
	 * @param string $typeName
	 * @return bool
	 */
	final public static function isTypedObjectArray(
		array $array,
		string $typeName
	): bool {
		foreach ($array as $item) {
			if (!($item instanceof $typeName)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Validates multidimensional array to have scalar or NULL leaves
	 *
	 * @param mixed[] $array
	 * @return bool
	 */
	final public static function isScalarLeavesArray(
		array $array
	): bool {
		foreach ($array as $item) {
			if (\is_array($item)) {
				$isScalar = self::isScalarLeavesArray($item);

				if (!$isScalar) {
					return false;
				}
			} elseif ($item !== null && !\is_scalar($item)) {
				return false;
			}
		}

		return true;
	}

}
