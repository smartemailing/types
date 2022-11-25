<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Helpers\ExtractableHelpers;

abstract class Dates implements ExtractableTypeInterface
{

	final public static function from(
		mixed $value
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
     * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
     * @throws \SmartEmailing\Types\InvalidTypeException
     */
    final public static function extract(
        $data,
        string $key
    ): \DateTime {
        $value = ExtractableHelpers::extractValue($data, $key);

        try {
            return self::from($value);
        } catch (InvalidTypeException $exception) {
            throw $exception->wrap($key);
        }
    }

    /**
     * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
     */
    final public static function extractOrNull(
        $data,
        string $key,
        bool $nullIfInvalid = false
    ): ?\DateTime {
        $value = ExtractableHelpers::extractValueOrNull($data, $key);

        if ($value === null) {
            return null;
        }

        try {
            return self::fromOrNull($value, $nullIfInvalid);
        } catch (InvalidTypeException $exception) {
            throw $exception->wrap($key);
        }
    }

	public static function fromOrNull(
		mixed $value,
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

}
