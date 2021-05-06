<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

abstract class DatesImmutable
{

	final public static function from(
		mixed $value
	): \DateTimeImmutable {
		$dateTime = Dates::from($value);

		return self::immutate($dateTime);
	}

	public static function fromOrNull(
		mixed $value,
		bool $getNullIfInvalid = false
	): \DateTimeImmutable | null {
		$dateTime = Dates::fromOrNull($value, $getNullIfInvalid);

		if ($dateTime === null) {
			return null;
		}

		return self::immutate($dateTime);
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extract(
		array | \ArrayAccess $data,
		string $key
	): \DateTimeImmutable {
		$dateTime = Dates::extract(
			$data,
			$key
		);

		return self::immutate($dateTime);
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 */
	final public static function extractOrNull(
		array | \ArrayAccess $data,
		string $key,
		bool $getNullIfInvalid = false
	): \DateTimeImmutable | null {
		$dateTime = Dates::extractOrNull(
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
