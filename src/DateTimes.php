<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Arrays;

abstract class DateTimes implements ExtractableTypeInterface
{

	/**
	 * @param mixed $value
	 * @return \DateTime
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
	 * @param bool $nullIfInvalid
	 * @return \DateTime
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
	 * @param array<mixed> $data
	 * @param string $key
	 * @return \DateTime
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extract(
		array $data,
		string $key
	): \DateTime {
		$value = Arrays::get($data, $key, '');

		try {
			return self::from($value);
		} catch (InvalidTypeException $e) {
			throw new InvalidTypeException($key . ' -- ' . $e->getMessage());
		}
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return \DateTime
	 */
	final public static function extractOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid = false
	): ?\DateTime {
		if (!isset($data[$key])) {
			return null;
		}

		if ($nullIfInvalid) {
			try {
				return self::extract($data, $key);
			} catch (InvalidTypeException $e) {
				return null;
			}
		}

		return self::extract($data, $key);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @return \DateTime
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
	 * @param string $key
	 * @return \DateTime|null
	 * @deprecated Use Dates::extractDateOrNull
	 */
	final public static function extractDateOrNull(
		array &$data,
		string $key
	): ?\DateTime {
		return Dates::extractOrNull($data, $key);
	}

}
