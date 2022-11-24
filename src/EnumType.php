<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Helpers\ExtractableHelpers;

abstract class EnumType // implements ExtractableTypeInterface
{

	/**
	 * @template T
	 * @param class-string<T> $enumType
	 * @return T
	 */
	final public static function from(
		string $enumType,
		mixed $value
	)
	{
		if ($value instanceof $enumType) {
			return $value;
		}

		if (!\method_exists($enumType, 'from')) {
			throw InvalidTypeException::typeError($enumType, $value);
		}

		try {
			return $enumType::from($value);
		} catch (\ValueError | \TypeError $e) {
			throw InvalidTypeException::typeError($enumType, $value);
		}
	}

	/**
	 * @template T
	 * @param class-string<T> $enumType
	 * @return T|null
	 */
	final public static function fromOrNull(
		string $enumType,
		mixed $value,
		bool $nullIfInvalid = false
	)
	{
		if ($value === null) {
			return null;
		}

		try {
			return self::from(
				$enumType,
				$value
			);
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

	/**
	 * @template T
	 * @param class-string<T> $enumType
	 * @return T
	 */
	final public static function extract(
		string $enumType,
		mixed $data,
		string $key
	)
	{
		$value = ExtractableHelpers::extractValue(
			$data,
			$key
		);

		try {
			return self::from(
				$enumType,
				$value
			);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}
	}

	/**
	 * @template T
	 * @param class-string<T> $enumType
	 * @return T|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractOrNull(
		string $enumType,
		mixed $data,
		string $key,
		bool $nullIfInvalid = false
	)
	{
		$value = ExtractableHelpers::extractValueOrNull(
			$data,
			$key
		);

		if ($value === null) {
			return null;
		}

		try {
			return self::fromOrNull(
				$enumType,
				$value,
				$nullIfInvalid
			);
		} catch (InvalidTypeException $exception) {
			throw $exception->wrap($key);
		}
	}

}
