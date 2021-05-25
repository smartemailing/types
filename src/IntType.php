<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Validators;
use SmartEmailing\Types\Helpers\ExtractableHelpers;

abstract class IntType implements ExtractableTypeInterface
{

	/**
	 * @param mixed $value
	 * @return int
	 */
	final public static function from(
		$value
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
	final public static function fromOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?int {
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
	 * @return int
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extract(
		$data,
		string $key
	): int {
		$value = ExtractableHelpers::extractValue($data, $key);

		try {
			return self::from($value);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return int
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractOrNull(
		$data,
		string $key,
		bool $nullIfInvalid = false
	): ?int {
		$value = ExtractableHelpers::extractValueOrNull($data, $key);

		if ($value === null) {
			return null;
		}

		try {
			return self::fromOrNull($value, $nullIfInvalid);
		} catch (InvalidTypeException $exception) {
			throw $exception->wrap($key);
		}
	}

}
