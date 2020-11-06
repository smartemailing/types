<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Helpers\ExtractableHelpers;

abstract class Arrays
{

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
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return mixed[]|null
	 */
	final public static function getArrayOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?array {
		if (\is_array($value)) {
			return $value;
		}

		if ($value === null) {
			return null;
		}

		try {
			return self::getArray($value);
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

	/**
	 * Preserves keys
	 *
	 * @param mixed[] $data
	 * @param string $key
	 * @return mixed[]
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractArray(array $data, string $key): array
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
	 * @param bool $nullIfInvalid
	 * @return mixed[]|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractArrayOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid = false
	): ?array {
		if (!isset($data[$key])) {
			return null;
		}

		try {
			return self::extractArray($data, $key);
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

	/**
	 * @param mixed $value
	 * @return int[]
	 */
	final public static function getIntArray(
		$value
	): array {
		$array = self::getArray($value);

		$return = [];

		foreach ($array as $index => $item) {
			$return[$index] = PrimitiveTypes::getInt($item);
		}

		return $return;
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return int[]|null
	 */
	final public static function getIntArrayOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?array {
		$array = self::getArrayOrNull($value, $nullIfInvalid);

		if ($array === null) {
			return null;
		}

		$return = [];

		try {
			foreach ($array as $index => $item) {
				$return[$index] = PrimitiveTypes::getInt($item);
			}
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}

		return $return;
	}

	/**
	 * @param mixed[] $data
	 * @param string $key
	 * @return int[]
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractIntArray(
		array $data,
		string $key
	): array {
		$array = Arrays::extractArray($data, $key);

		try {
			$array = Arrays::getIntArray($array);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}

		return $array;
	}

	/**
	 * @param mixed[] $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return int[]|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractIntArrayOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid = false
	): ?array {
		$array = Arrays::extractArrayOrNull($data, $key, $nullIfInvalid);

		if ($array === null) {
			return null;
		}

		return self::getIntArrayOrNull($array, $nullIfInvalid);
	}

	/**
	 * @param mixed $value
	 * @return string[]
	 */
	final public static function getStringArray(
		$value
	): array {
		$array = self::getArray($value);

		$return = [];

		foreach ($array as $index => $item) {
			$return[$index] = PrimitiveTypes::getString($item);
		}

		return $return;
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return string[]|null
	 */
	final public static function getStringArrayOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?array {
		$array = self::getArrayOrNull($value, $nullIfInvalid);

		if ($array === null) {
			return null;
		}

		$return = [];

		try {
			foreach ($array as $index => $item) {
				$return[$index] = PrimitiveTypes::getString($item);
			}
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}

		return $return;
	}

	/**
	 * @param mixed[] $data
	 * @param string $key
	 * @return string[]
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractStringArray(
		array $data,
		string $key
	): array {
		$array = Arrays::extractArray($data, $key);

		try {
			$array = Arrays::getStringArray($array);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}

		return $array;
	}

	/**
	 * @param mixed[] $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return string[]|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractStringArrayOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid = false
	): ?array {
		$array = Arrays::extractArrayOrNull($data, $key, $nullIfInvalid);

		if ($array === null) {
			return null;
		}

		return self::getStringArrayOrNull($array, $nullIfInvalid);
	}

}
