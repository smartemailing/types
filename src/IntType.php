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
	final public static function get(
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
	final public static function getOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?int {
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
	 * @return int
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extract(
		array $data,
		string $key
	): int {
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
	 * @return int
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid = false
	): ?int {
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
