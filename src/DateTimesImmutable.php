<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

abstract class DateTimesImmutable
{

	final public static function from(
		mixed $value
	): \DateTimeImmutable {
		$dateTime = DateTimes::from($value);

		return self::immutate($dateTime);
	}

	/**
	 * @param mixed $value
	 * @param bool $getNullIfInvalid
	 * @return \DateTimeImmutable|null
	 */
	public static function fromOrNull(
		mixed $value,
		bool $getNullIfInvalid = false
	): \DateTimeImmutable | null {
		$dateTime = DateTimes::fromOrNull($value, $getNullIfInvalid);

		if ($dateTime === null) {
			return null;
		}

		return self::immutate($dateTime);
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @param string $key
	 * @return \DateTimeImmutable
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extract(
		array | \ArrayAccess $data,
		string $key
	): \DateTimeImmutable {
		$dateTime = DateTimes::extract(
			$data,
			$key
		);

		return self::immutate($dateTime);
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @param string $key
	 * @param bool $getNullIfInvalid
	 * @return \DateTimeImmutable
	 */
	final public static function extractOrNull(
		array | \ArrayAccess $data,
		string $key,
		bool $getNullIfInvalid = false
	): \DateTimeImmutable | null {
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

	private static function immutate(
		\DateTime $dateTime
	): \DateTimeImmutable {
		return \DateTimeImmutable::createFromMutable(
			$dateTime
		);
	}

}
