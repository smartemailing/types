<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Nette\Utils\Arrays;

abstract class DateTimes
{

	use ObjectMixinTrait;

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

		if (\is_string($value) && \preg_match('#^\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d\z#', $value)) {
			return \DateTime::createFromFormat(DateTimeFormat::DATETIME, $value);
		}
		throw new InvalidTypeException(
			'Value ' . $value . ' must be string in ' . DateTimeFormat::DATETIME . ' format'
		);
	}

	/**
	 * @param mixed[] $data
	 * @param string $key
	 * @return \DateTime
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extract(
		array & $data,
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
	 * @param mixed[] $data
	 * @param string $key
	 * @return \DateTime
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractDate(
		array &$data,
		string $key
	): \DateTime {
		$date = Arrays::get($data, $key, '');

		if ($date instanceof \DateTimeInterface) {
			$date = $date->format('Y-m-d');
		}

		if (\is_string($date) && \preg_match('/^\d\d\d\d-\d\d-\d\d\z/', $date)) {
			return \DateTime::createFromFormat('Y-m-d H:i:s', $date . ' 00:00:00');
		}

		throw new InvalidTypeException('Parameter ' . $key . ' must be a valid date');
	}

	/**
	 * @param mixed[] $data
	 * @param string $key
	 * @return \DateTime|null
	 */
	final public static function extractDateOrNull(
		array &$data,
		string $key
	): ?\DateTime {
		if (!isset($data[$key])) {
			return null;
		}
		return self::extractDate($data, $key);
	}

	// @codingStandardsIgnoreStart

	/**
	 * @param mixed[] $data
	 * @param string $key
	 * @param bool $getNullIfInvalid
	 * @return \DateTime
	 */
	final public static function extractOrNull(
		array & $data,
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

	// @codingStandardsIgnoreEnd

}
