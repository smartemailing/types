<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Nette\Utils\Arrays;

abstract class Dates
{

	use ObjectMixinTrait;

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
			return \DateTime::createFromFormat(DateTimeFormat::DATETIME, $value . ' 00:00:00');
		}

		throw new InvalidTypeException(
			'Value ' . $value . ' must be string in ' . DateTimeFormat::DATE . ' format'
		);
	}

	/**
	 * @param mixed $value
	 * @param bool $getNullIfInvalid
	 * @return \DateTime
	 */
	public static function fromOrNull(
		$value,
		bool $getNullIfInvalid = false
	): ?\DateTime {
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

}
