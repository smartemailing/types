<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

abstract class DatesImmutable implements ExtractableTypeInterface
{

	/**
	 * @param mixed $value
	 */
	final public static function from(
		$value
	): \DateTimeImmutable {
		$dateTime = Dates::from($value);

		return self::immutate($dateTime);
	}

    /**
     * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
     * @throws \SmartEmailing\Types\InvalidTypeException
     */
    final public static function extract(
        $data,
        string $key
    ): \DateTimeImmutable {
        $dateTime = Dates::extract(
            $data,
            $key
        );

        return self::immutate($dateTime);
    }

    /**
     * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
     */
    final public static function extractOrNull(
        $data,
        string $key,
        bool $nullIfInvalid = false
    ): ?\DateTimeImmutable {
        $dateTime = Dates::extractOrNull(
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
	 * @param mixed $value
	 */
	public static function fromOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?\DateTimeImmutable {
		$dateTime = Dates::fromOrNull($value, $nullIfInvalid);

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
