<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Arrays;

abstract class Dates implements ExtractableTypeInterface
{

	/**
	 * @param mixed $value
	 * @return \DateTime
	 */
	final public static function from(
		$value
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

}
