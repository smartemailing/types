<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Helpers\ExtractableHelpers;

abstract class Arrays implements ExtractableTypeInterface
{

	/**
	 * @param mixed $value
	 * @return array<mixed>
	 */
	public static function get(
		$value
	): array
	{
		if (\is_array($value)) {
			return $value;
		}

		throw InvalidTypeException::typeError('array', $value);
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return array<mixed>
	 */
	public static function getOrNull(
		$value,
		bool $nullIfInvalid
	): ?array
	{
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
	 * @param array<mixed> $data
	 * @param string $key
	 * @return array<mixed>
	 */
	public static function extract(
		array $data,
		string $key
	): array
	{
		$value = ExtractableHelpers::extractValue($data, $key);

		try {
			return self::get($value);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return array<mixed>|null
	 */
	public static function extractOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid
	): ?array
	{
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

	/**
	 * @param mixed $value
	 * @return array<mixed>
	 * @deprecated use Arrays::get
	 */
	final public static function getArray(
		$value
	): array {
		return self::get($value);
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return array<mixed>|null
	 * @deprecated use Arrays::getOrNull
	 */
	final public static function getArrayOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?array {
		return self::getOrNull($value, $nullIfInvalid);
	}

	/**
	 * Preserves keys
	 *
	 * @param array<mixed> $data
	 * @param string $key
	 * @return array<mixed>
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated use Arrays::extract
	 */
	final public static function extractArray(
		array $data,
		string $key
	): array
	{
		return self::extract($data, $key);
	}

	/**
	 * Preserves keys
	 *
	 * @param array<mixed> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return array<mixed>|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated use Arrays::extractOrNull
	 */
	final public static function extractArrayOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid = false
	): ?array {
		return self::extractOrNull($data, $key, $nullIfInvalid);
	}

	/**
	 * @param mixed $value
	 * @return array<int>
	 * @deprecated use IntArray::get
	 */
	final public static function getIntArray(
		$value
	): array {
		return IntArray::get($value);
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return array<int>|null
	 * @deprecated use IntArray::getOrNull
	 */
	final public static function getIntArrayOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?array {
		return IntArray::getOrNull($value, $nullIfInvalid);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @return array<int>
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated use IntArray::extract
	 */
	final public static function extractIntArray(
		array $data,
		string $key
	): array {
		return IntArray::extract($data, $key);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return array<int>|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated use IntArray::extractOrNull
	 */
	final public static function extractIntArrayOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid = false
	): ?array {
		return IntArray::extractOrNull($data, $key, $nullIfInvalid);
	}

	/**
	 * @param mixed $value
	 * @return array<float>
	 * @deprecated use FloatArray::get
	 */
	final public static function getFloatArray(
		$value
	): array {
		return FloatArray::get($value);
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return array<float>|null
	 * @deprecated use FloatArray::getOrNull
	 */
	final public static function getFloatArrayOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?array {
		return FloatArray::getOrNull($value, $nullIfInvalid);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @return array<float>
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated use FloatArray::extract
	 */
	final public static function extractFloatArray(
		array $data,
		string $key
	): array {
		return FloatArray::extract($data, $key);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return array<float>|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated use FloatArray::extractOrNull
	 */
	final public static function extractFloatArrayOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid = false
	): ?array {
		return FloatArray::extractOrNull($data, $key, $nullIfInvalid);
	}

	/**
	 * @param mixed $value
	 * @return array<string>
	 * @deprecated use StringArray::get
	 */
	final public static function getStringArray(
		$value
	): array {
		return StringArray::get($value);
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return array<string>|null
	 * @deprecated use StringArray::getOrNull
	 */
	final public static function getStringArrayOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?array {
		return StringArray::getOrNull($value, $nullIfInvalid);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @return array<string>
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated use StringArray::extract
	 */
	final public static function extractStringArray(
		array $data,
		string $key
	): array {
		return StringArray::extract($data, $key);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return array<string>|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated use StringArray::extractOrNull
	 */
	final public static function extractStringArrayOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid = false
	): ?array {
		return StringArray::extractOrNull($data, $key, $nullIfInvalid);
	}

}
