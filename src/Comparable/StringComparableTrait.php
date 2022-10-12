<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Comparable;

use SmartEmailing\Types\ToStringInterface;

trait StringComparableTrait
{

	/**
	 * @param mixed $that
	 */
	public function equals(
		$that
	): bool
	{
		return $this instanceof ToStringInterface &&
			$that instanceof ToStringInterface &&
			\get_class($that) === static::class &&
			(string) $this === (string) $that;
	}

}
