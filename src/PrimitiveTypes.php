<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

/**
 * @deprecated use StringType, IntType, FloatType, BoolType instead
 */
abstract class PrimitiveTypes
{

	/**
	 * @param mixed $value
	 * @return int
	 * @deprecated use IntType::get
	 */
	final public static function getInt(
		$value
	): int {
		return IntType::get($value);
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return int|null
	 * @deprecated use IntType::getOrNull
	 */
	final public static function getIntOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?int {
		return IntType::getOrNull($value, $nullIfInvalid);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @return int
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated use IntType::extract
	 */
	final public static function extractInt(
		array $data,
		string $key
	): int {
		return IntType::extract($data, $key);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return int
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated use IntType::extractOrNull
	 */
	final public static function extractIntOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid = false
	): ?int {
		return IntType::extractOrNull($data, $key, $nullIfInvalid);
	}

	/**
	 * @param mixed $value
	 * @return float
	 * @deprecated use FloatType::get
	 */
	final public static function getFloat(
		$value
	): float {
		return FloatType::get($value);
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return float|null
	 * @deprecated use FloatType::getOrNull
	 */
	final public static function getFloatOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?float {
		return FloatType::getOrNull($value, $nullIfInvalid);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @return float
	 * @deprecated use FloatType::extract
	 */
	final public static function extractFloat(
		array $data,
		string $key
	): float {
		return FloatType::extract($data, $key);
	}

	/**
	 * @param array<float> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return float
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated use FloatType::extractOrNull
	 */
	final public static function extractFloatOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid = false
	): ?float {
		return FloatType::extractOrNull($data, $key, $nullIfInvalid);
	}

	/**
	 * @param mixed $value
	 * @return string
	 * @deprecated use StringType::get
	 */
	final public static function getString(
		$value
	): string {
		return StringType::get($value);
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return string|null
	 * @deprecated use StringType::getOrNull
	 */
	final public static function getStringOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?string {
		return StringType::getOrNull($value, $nullIfInvalid);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @return string
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated use StringType::extract
	 */
	final public static function extractString(
		array $data,
		string $key
	): string {
		return StringType::extract($data, $key);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return string|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated use StringType::extractOrNull
	 */
	final public static function extractStringOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid = false
	): ?string {
		return StringType::extractOrNull($data, $key, $nullIfInvalid);
	}

	/**
	 * @param mixed $value
	 * @return bool
	 * @deprecated use BoolType::get
	 */
	final public static function getBool(
		$value
	): bool {
		return BoolType::get($value);
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return bool|null
	 * @deprecated use BoolType::getOrNull
	 */
	final public static function getBoolOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?bool {
		return BoolType::getOrNull($value, $nullIfInvalid);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @return bool
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated use BoolType::extract
	 */
	final public static function extractBool(
		array $data,
		string $key
	): bool {
		return BoolType::extract($data, $key);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return bool|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated use BoolType::extractOrNull
	 */
	final public static function extractBoolOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid = false
	): ?bool {
		return BoolType::extractOrNull($data, $key, $nullIfInvalid);
	}

	/**
	 * @param mixed $value
	 * @return array<mixed>
	 * @deprecated use Arrays::get instead
	 */
	final public static function getArray(
		$value
	): array {
		return Arrays::get($value);
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
		array &$data,
		string $key
	): array
	{
		return Arrays::extract(
			$data,
			$key
		);
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
		array &$data,
		string $key,
		bool $nullIfInvalid = false
	): ?array
	{
		return Arrays::extractOrNull(
			$data,
			$key,
			$nullIfInvalid
		);
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
		return StringArray::extract(
			$data,
			$key
		);
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
		return IntArray::extract(
			$data,
			$key
		);
	}

}
