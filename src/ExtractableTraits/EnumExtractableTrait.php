<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

trait EnumExtractableTrait
{

	use ExtractableTrait;

	/**
	 * @return static
	 */
	final public static function from(
		mixed $data
	) {
		if ($data instanceof self) {
			return $data;
		}

		return self::get($data);
	}

}
