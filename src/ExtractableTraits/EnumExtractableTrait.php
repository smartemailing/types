<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

trait EnumExtractableTrait
{

	use ExtractableTrait;

	final public static function from(
		mixed $data
	): static
	{
		if ($data instanceof self) {
			return $data;
		}

		return self::get($data);
	}

}
