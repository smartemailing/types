<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

use SmartEmailing\Types\Enum;

trait EnumExtractableTrait
{

	use ExtractableTrait;

	abstract public static function get(
		mixed $value
	): Enum;

	/**
	 * @return static
	 */
	final public static function from(
		mixed $data
	): static {
		if ($data instanceof self) {
			return $data;
		}

		return static::get($data);
	}

}
