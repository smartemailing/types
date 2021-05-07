<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Helpers\ExtractableHelpers;

abstract class FloatType implements ExtractableTypeInterface
{

	/**
	 * @param mixed $value
	 * @return float
	 */
	final public static function get(
		$value
	): float {
		if (\is_string($value)) {
			$value = \strtr(
				$value,
				[
					',' => '.',
				]
			);
		}

		if (\is_numeric($value)) {
			return (float) $value;
		}

		throw InvalidTypeException::typeError('float', $value);
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return float|null
	 */
	final public static function getOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?float {
		if ($value === null) {
			return null;
		}

		try {
			return self::get($value);
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @return float
	 */
	final public static function extract(
		array $data,
		string $key
	): float {
		$value = ExtractableHelpers::extractValue($data, $key);

		try {
			return self::get($value);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}
	}

	/**
	 * @param array<float> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return float
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid = false
	): ?float {
		if (!isset($data[$key])) {
			return null;
		}

		try {
			return self::extract($data, $key);
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

}
