<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Helpers\ExtractableHelpers;

abstract class StringType implements ExtractableTypeInterface
{

	/**
	 * @param mixed $value
	 * @return string
	 */
	final public static function from(
		$value
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
	final public static function fromOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?string {
		if ($value === null) {
			return null;
		}

		try {
			return self::from($value);
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
	 * @param string $key
	 * @return string
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extract(
		$data,
		string $key
	): string {
		$value = ExtractableHelpers::extractValue($data, $key);

		try {
			return self::from($value);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}
	}

	/**
	 * @param \ArrayAccess<mixed,mixed>|array<mixed> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return string|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractOrNull(
		$data,
		string $key,
		bool $nullIfInvalid = false
	): ?string {
		$value = ExtractableHelpers::extractValueOrNull($data, $key);

		if ($value === null || $value === '') {
			return null;
		}

		try {
			return self::fromOrNull($value, $nullIfInvalid);
		} catch (InvalidTypeException $exception) {
			throw $exception->wrap($key);
		}
	}

}
