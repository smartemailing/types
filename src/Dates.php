<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Helpers\ExtractableHelpers;

abstract class Dates
{

	final public static function from(
		mixed $value
	): \DateTime {
		if ($value instanceof \DateTimeInterface) {
			$value = $value->format('Y-m-d');
		}

		if (\is_string($value) && \preg_match('#^\d\d\d\d-\d\d-\d\d\z#', $value)) {
			$date = \DateTime::createFromFormat(DateTimeFormat::DATETIME, $value . ' 00:00:00');

			if ($date instanceof \DateTime && DateTimeFormatter::format($date, DateTimeFormat::DATE) === $value) {
				return $date;
			}
		}

		throw new InvalidTypeException(
			'Value ' . $value . ' must be string in ' . DateTimeFormat::DATE . ' format'
		);
	}

	public static function fromOrNull(
		mixed $value,
		bool $getNullIfInvalid = false
	): \DateTime | null {
		if ($value === null) {
			return null;
		}

		try {
			return self::from($value);
		} catch (InvalidTypeException $e) {
			if ($getNullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extract(
		array | \ArrayAccess $data,
		string $key
	): \DateTime {
		$value = ExtractableHelpers::extractValue($data, $key);

		try {
			return self::from($value);
		} catch (InvalidTypeException $e) {
			throw new InvalidTypeException($key . ' -- ' . $e->getMessage());
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 */
	final public static function extractOrNull(
		array | \ArrayAccess $data,
		string $key,
		bool $getNullIfInvalid = false
	): \DateTime | null {
		if (!isset($data[$key])) {
			return null;
		}

		if ($getNullIfInvalid) {
			try {
				return self::extract($data, $key);
			} catch (InvalidTypeException) {
				return null;
			}
		}

		return self::extract($data, $key);
	}

}
