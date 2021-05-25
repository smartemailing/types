<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

abstract class DateTimesImmutable implements ExtractableTypeInterface
{

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
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return \DateTimeImmutable
	 */
	public static function fromOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?\DateTimeImmutable {
		$dateTime = DateTimes::fromOrNull($value, $nullIfInvalid);

		if ($dateTime === null) {
			return null;
		}

		return self::immutate($dateTime);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @return \DateTimeImmutable
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extract(
		array $data,
		string $key
	): \DateTimeImmutable {
		$dateTime = DateTimes::extract(
			$data,
			$key
		);

		return self::immutate($dateTime);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return \DateTimeImmutable
	 */
	final public static function extractOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid = false
	): ?\DateTimeImmutable {
		$dateTime = DateTimes::extractOrNull(
			$data,
			$key,
			$nullIfInvalid
		);

		if ($dateTime === null) {
			return null;
		}

		return self::immutate($dateTime);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @return \DateTimeImmutable
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 * @deprecated Use DatesImmutable::extract
	 */
	final public static function extractDate(
		array &$data,
		string $key
	): \DateTimeImmutable {
		return DatesImmutable::extract($data, $key);
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @return \DateTimeImmutable|null
	 * @deprecated Use DatesImmutable::extractDateOrNull
	 */
	final public static function extractDateOrNull(
		array &$data,
		string $key
	): ?\DateTimeImmutable {
		return DatesImmutable::extractOrNull($data, $key);
	}

	private static function immutate(
		\DateTime $dateTime
	): \DateTimeImmutable {
		return \DateTimeImmutable::createFromMutable(
			$dateTime
		);
	}

}
