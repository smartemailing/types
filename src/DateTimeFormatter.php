<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

abstract class DateTimeFormatter
{

	final public static function formatOrNull(
		\DateTimeInterface | null $dateTime,
		string $format = DateTimeFormat::DATETIME
	): string | null {
		if ($dateTime === null) {
			return null;
		}

		return self::format($dateTime, $format);
	}

	final public static function format(
		\DateTimeInterface $dateTime,
		string $format = DateTimeFormat::DATETIME
	): string {
		return $dateTime->format($format);
	}

}
