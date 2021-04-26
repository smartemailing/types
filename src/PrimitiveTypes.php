<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Strings;
use Nette\Utils\Validators;
use SmartEmailing\Types\Helpers\ExtractableHelpers;

abstract class PrimitiveTypes
{

	final public static function getInt(
		mixed $value
	): int {
		if (Validators::isNumericInt($value)) {
			return (int) $value;
		}

		throw InvalidTypeException::typeError('int', $value);
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return int|null
	 */
	final public static function getIntOrNull(
		mixed $value,
		bool $nullIfInvalid = false
	): int | null {
		if ($value === null) {
			return null;
		}

		try {
			return self::getInt($value);
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @param string|int $key
	 * @return int
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractInt(
		array | \ArrayAccess $data,
		string | int $key
	): int {
		$value = ExtractableHelpers::extractValue($data, $key);

		try {
			return self::getInt($value);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}
	}

	/**
	 * @param mixed $value
	 * @return float
	 */
	final public static function getFloat(
		mixed $value
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
	final public static function getFloatOrNull(
		mixed $value,
		bool $nullIfInvalid = false
	): float | null {
		if ($value === null) {
			return null;
		}

		try {
			return self::getFloat($value);
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @param string|int $key
	 * @return float
	 */
	final public static function extractFloat(
		array | \ArrayAccess $data,
		string | int $key
	): float {
		$value = ExtractableHelpers::extractValue($data, $key);

		try {
			return self::getFloat($value);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @param string|int $key
	 * @param bool $nullIfInvalid
	 * @return float|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractFloatOrNull(
		array | \ArrayAccess $data,
		string | int $key,
		bool $nullIfInvalid = false
	): float | null {
		if (!isset($data[$key])) {
			return null;
		}

		try {
			return self::extractFloat($data, $key);
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @param string|int $key
	 * @param bool $nullIfInvalid
	 * @return int|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractIntOrNull(
		array | \ArrayAccess $data,
		string | int $key,
		bool $nullIfInvalid = false
	): int | null {
		if (!isset($data[$key])) {
			return null;
		}

		try {
			return self::extractInt($data, $key);
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @param string|int $key
	 * @param bool $nullIfInvalid
	 * @return bool|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractBoolOrNull(
		array | \ArrayAccess $data,
		string | int $key,
		bool $nullIfInvalid = false
	): ?bool {
		if (!isset($data[$key])) {
			return null;
		}

		try {
			return self::extractBool($data, $key);
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @param string|int $key
	 * @param bool $nullIfInvalid
	 * @return string|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractStringOrNull(
		array | \ArrayAccess $data,
		string | int $key,
		bool $nullIfInvalid = false
	): string | null {
		if (
			!isset($data[$key])
			|| $data[$key] === ''
		) {
			return null;
		}

		try {
			return self::extractString($data, $key);
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

	final public static function getString(
		mixed $value
	): string {
		if (\is_scalar($value)) {
			return (string) $value;
		}

		throw InvalidTypeException::typeError('string', $value);
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return string|null
	 */
	final public static function getStringOrNull(
		mixed $value,
		bool $nullIfInvalid = false
	): string | null {
		if ($value === null) {
			return null;
		}

		try {
			return self::getString($value);
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @param string|int $key
	 * @return string
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractString(
		array | \ArrayAccess $data,
		string | int$key
	): string {
		$value = ExtractableHelpers::extractValue($data, $key);

		try {
			return self::getString($value);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}
	}

	final public static function getBool(
		mixed $value
	): bool {
		if (\is_bool($value)) {
			return $value;
		}

		if (\is_string($value)) {
			$value = Strings::lower($value);
		}

		if (\in_array($value, [false, 0, '0', 'false'], true)) {
			return false;
		}

		if (\in_array($value, [true, 1, '1', 'true'], true)) {
			return true;
		}

		throw InvalidTypeException::typeError('bool', $value);
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return bool|null
	 */
	final public static function getBoolOrNull(
		mixed $value,
		bool $nullIfInvalid = false
	): bool | null {
		if ($value === null) {
			return null;
		}

		try {
			return self::getBool($value);
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @param string|int $key
	 * @return bool
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractBool(
		array | \ArrayAccess $data,
		string | int $key
	): bool {
		$value = ExtractableHelpers::extractValue($data, $key);

		try {
			return self::getBool($value);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}
	}

}
