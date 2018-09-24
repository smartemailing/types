<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;

abstract class DateTimeFormatter
{

	use ObjectMixinTrait;

	final public static function formatOrNull(
		?\DateTimeInterface $dateTime,
		string $format = DateTimeFormat::DATETIME
	): ?string {
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
