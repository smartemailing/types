<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Helpers\ExtractableHelpers;

abstract class DateTimes
{

	final public static function from(
		mixed $value
	): \DateTime {
		if ($value instanceof \DateTime) {
			return $value;
		}

		if ($value instanceof \DateTimeImmutable) {
			$value = DateTimeFormatter::format($value);
		}

		if (\is_string($value) && \preg_match('#^\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d(\.\d+)?\z#', $value, $matches)) {
			if (\count($matches) > 1) {
				$value = \substr($value, 0, \strlen($value) - \strlen($matches[1]));
			}

			$date = \DateTime::createFromFormat(DateTimeFormat::DATETIME, $value);

			if ($date instanceof \DateTime && DateTimeFormatter::format($date, DateTimeFormat::DATETIME) === $value) {
				return $date;
			}
		}

		throw new InvalidTypeException(
			'Value ' . $value . ' must be string in ' . DateTimeFormat::DATETIME . ' format'
		);
	}

	/**
	 * @param mixed $value
	 * @param bool $getNullIfInvalid
	 * @return \DateTime|null
	 */
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
	 * @param string $key
	 * @return \DateTime
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
	 * @param string $key
	 * @param bool $getNullIfInvalid
	 * @return \DateTime
	 */
	final public static function extractOrNull(
		array | \ArrayAccess $data,
		string $key,
		bool $getNullIfInvalid = false
	): ?\DateTime {
		if (!isset($data[$key])) {
			return null;
		}

		if ($getNullIfInvalid) {
			try {
				return self::extract($data, $key);
			} catch (InvalidTypeException $e) {
				return null;
			}
		}

		return self::extract($data, $key);
	}

}
