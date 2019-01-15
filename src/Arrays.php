<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\Helpers\ExtractableHelpers;

abstract class Arrays
{

	use ObjectMixinTrait;

	/**
	 * @param mixed $value
	 * @return mixed[]
	 */
	final public static function getArray(
		$value
	): array {
		if (\is_array($value)) {
			return $value;
		}

		throw InvalidTypeException::typeError('array', $value);
	}

	/**
	 * Preserves keys
	 *
	 * @param mixed[] $data
	 * @param string $key
	 * @return mixed[]
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractArray(array &$data, string $key): array
	{
		$value = ExtractableHelpers::extractValue($data, $key);

		try {
			return self::getArray($value);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}
	}

	/**
	 * Preserves keys
	 *
	 * @param mixed[] $data
	 * @param string $key
	 * @return mixed[]|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractArrayOrNull(
		array &$data,
		string $key
	): ?array {
		if (!isset($data[$key]) || $data[$key] === null) {
			return null;
		}

		return self::extractArray($data, $key);
	}

}
