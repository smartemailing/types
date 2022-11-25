<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Comparable;

use SmartEmailing\Types\ToStringInterface;

trait StringComparableTrait
{

	public function equals(
		mixed $that
	): bool
	{
		return $this instanceof ToStringInterface &&
			$that instanceof ToStringInterface &&
			\get_class($that) === static::class &&
			(string) $this === (string) $that;
	}

}
