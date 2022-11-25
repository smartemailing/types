<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

abstract class DateTimesImmutable implements ExtractableTypeInterface
{

	final public static function from(
		mixed $value
	): \DateTimeImmutable {
		$dateTime = DateTimes::from($value);

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
        $dateTime = DateTimes::extract(
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
     * @deprecated Use DatesImmutable::extractDateOrNull
     */
    final public static function extractDateOrNull(
        array &$data,
        string $key
    ): ?\DateTimeImmutable {
        return DatesImmutable::extractOrNull($data, $key);
    }

	public static function fromOrNull(
		mixed $value,
		bool $nullIfInvalid = false
	): ?\DateTimeImmutable {
		$dateTime = DateTimes::fromOrNull($value, $nullIfInvalid);

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
