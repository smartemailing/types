<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

/**
 * @deprecated use StringType, IntType, FloatType, BoolType, StringArray, IntArray, FloatArray, BoolArray instead
 */
abstract class PrimitiveTypes
{

	/**
	 * @deprecated use IntType::from
	 */
	final public static function getInt(
		mixed $value
	): int {
		return IntType::from($value);
	}

	/**
	 * @deprecated use IntType::fromOrNull
	 */
	final public static function getIntOrNull(
		mixed $value,
		bool $nullIfInvalid = false
	): ?int {
		return IntType::fromOrNull($value, $nullIfInvalid);
	}

	/**
	 * @param array<mixed> $data
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
	 * @deprecated use FloatType::from
	 */
	final public static function getFloat(
		mixed $value
	): float {
		return FloatType::from($value);
	}

	/**
	 * @deprecated use FloatType::fromOrNull
	 */
	final public static function getFloatOrNull(
		mixed $value,
		bool $nullIfInvalid = false
	): ?float {
		return FloatType::fromOrNull($value, $nullIfInvalid);
	}

	/**
	 * @param array<mixed> $data
	 * @deprecated use FloatType::extract
	 */
	final public static function extractFloat(
		array $data,
		string $key
	): float {
		return FloatType::extract($data, $key);
	}

	/**
	 * @param array<mixed> $data
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
	 * @deprecated use StringType::from
	 */
	final public static function getString(
		mixed $value
	): string {
		return StringType::from($value);
	}

	/**
	 * @deprecated use StringType::fromOrNull
	 */
	final public static function getStringOrNull(
		mixed $value,
		bool $nullIfInvalid = false
	): ?string {
		return StringType::fromOrNull($value, $nullIfInvalid);
	}

	/**
	 * @param array<mixed> $data
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
	 * @deprecated use BoolType::from
	 */
	final public static function getBool(
		mixed $value
	): bool {
		return BoolType::from($value);
	}

	/**
	 * @deprecated use BoolType::fromOrNull
	 */
	final public static function getBoolOrNull(
		mixed $value,
		bool $nullIfInvalid = false
	): ?bool {
		return BoolType::fromOrNull($value, $nullIfInvalid);
	}

	/**
	 * @param array<mixed> $data
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
	 * @return array<mixed>
	 * @deprecated use Arrays::from instead
	 */
	final public static function getArray(
		mixed $value
	): array {
		return Arrays::from($value);
	}

	/**
	 * Preserves keys
	 *
	 * @param array<mixed> $data
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
