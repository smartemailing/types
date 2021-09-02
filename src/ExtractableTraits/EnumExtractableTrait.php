<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

trait EnumExtractableTrait
{

	use ExtractableTrait;

	/**
	 * @param mixed $data
	 * @return static
	 */
	final public static function from(
		$data
	) {
		if ($data instanceof self) {
			return $data;
		}

		return self::get($data);
	}

}
