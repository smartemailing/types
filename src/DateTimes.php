<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Helpers\ExtractableHelpers;

abstract class DateTimes implements ExtractableTypeInterface
{

	/**
	 * @param mixed $value
	 */
	final public static function from(
		$value
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
	 */
	public static function fromOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?\DateTime {
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
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extract(
		$data,
		string $key
	): \DateTime {
		$value = ExtractableHelpers::extractValue($data, $key);

		try {
			return self::from($value);
		} catch (InvalidTypeException $exception) {
			throw $exception->wrap($key);
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
	 */
	final public static function extractOrNull(
		$data,
		string $key,
		bool $nullIfInvalid = false
	): ?\DateTime {
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

	/**
	 * @param array<mixed> $data
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated Use Dates::extract
	 */
	final public static function extractDate(
		array &$data,
		string $key
	): \DateTime {
		return Dates::extract($data, $key);
	}

	/**
	 * @param array<mixed> $data
	 * @deprecated Use Dates::extractDateOrNull
	 */
	final public static function extractDateOrNull(
		array &$data,
		string $key
	): ?\DateTime {
		return Dates::extractOrNull($data, $key);
	}

}
