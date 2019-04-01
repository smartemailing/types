<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;

abstract class DatesImmutable
{

	use ObjectMixinTrait;

	/**
	 * @param mixed $value
	 * @return \DateTimeImmutable
	 */
	final public static function from(
		$value
	): \DateTimeImmutable {
		$dateTime = Dates::from($value);

		return self::immutate($dateTime);
	}

	/**
	 * @param mixed $value
	 * @param bool $getNullIfInvalid
	 * @return \DateTimeImmutable
	 */
	public static function fromOrNull(
		$value,
		bool $getNullIfInvalid = false
	): ?\DateTimeImmutable {
		$dateTime = Dates::fromOrNull($value, $getNullIfInvalid);

		if ($dateTime === null) {
			return null;
		}

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
		$dateTime = Dates::extract(
			$data,
			$key
		);

		return self::immutate($dateTime);
	}

	private static function immutate(
		\DateTime $dateTime
	): \DateTimeImmutable {
		return \DateTimeImmutable::createFromMutable(
			$dateTime
		);
	}

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

}
