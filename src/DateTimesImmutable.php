<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;

abstract class DateTimesImmutable
{

	use ObjectMixinTrait;

	/**
	 * @param mixed $value
	 * @return \DateTimeImmutable
	 */
	final public static function from(
		$value
	): \DateTimeImmutable {
		$dateTime = DateTimes::from($value);
		return self::immutate($dateTime);
	}

	/**
	 * @param mixed[] $data
	 * @param string $key
	 * @return \DateTimeImmutable
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extract(
		array & $data,
		string $key
	): \DateTimeImmutable {
		$dateTime = DateTimes::extract(
			$data,
			$key
		);
		return self::immutate($dateTime);
	}

	/**
	 * @param mixed[] $data
	 * @param string $key
	 * @return \DateTimeImmutable
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractDate(
		array &$data,
		string $key
	): \DateTimeImmutable {
		$dateTime = DateTimes::extractDate(
			$data,
			$key
		);
		return self::immutate($dateTime);
	}

	/**
	 * @param mixed[] $data
	 * @param string $key
	 * @return \DateTimeImmutable|null
	 */
	final public static function extractDateOrNull(
		array &$data,
		string $key
	): ?\DateTimeImmutable {
		$dateTime = DateTimes::extractDateOrNull(
			$data,
			$key
		);
		if ($dateTime === null) {
			return null;
		}
		return self::immutate($dateTime);
	}

	private static function immutate(
		\DateTime $dateTime
	): \DateTimeImmutable {
		return \DateTimeImmutable::createFromMutable(
			$dateTime
		);
	}

	// @codingStandardsIgnoreStart

	/**
	 * @param mixed[] $data
	 * @param string $key
	 * @param bool $getNullIfInvalid
	 * @return \DateTimeImmutable
	 */
	final public static function extractOrNull(
		array & $data,
		string $key,
		bool $getNullIfInvalid = false
	): ?\DateTimeImmutable {

		$dateTime = DateTimes::extractOrNull(
			$data,
			$key,
			$getNullIfInvalid
		);

		if ($dateTime === null) {
			return null;
		}

		return self::immutate($dateTime);
	}

	// @codingStandardsIgnoreEnd

}
