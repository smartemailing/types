<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Strings;
use SmartEmailing\Types\Helpers\ExtractableHelpers;

abstract class BoolType implements ExtractableTypeInterface
{

	/**
	 * @param mixed $value
	 * @return bool
	 */
	final public static function from(
		$value
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
	final public static function fromOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?bool {
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
	 * @return bool
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extract(
		$data,
		string $key
	): bool {
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
	 * @return bool|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractOrNull(
		$data,
		string $key,
		bool $nullIfInvalid = false
	): ?bool {
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
