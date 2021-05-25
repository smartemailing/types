<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Comparable;

use SmartEmailing\Types\ToArrayInterface;

trait ArrayComparableTrait
{

	/**
	 * @param mixed $that
	 * @return bool
	 */
	public function equals(
		$that
	): bool
	{
		return $this instanceof ToArrayInterface &&
			$that instanceof ToArrayInterface &&
			\get_class($that) === static::class &&
			$this->toArray() === $that->toArray();
	}

}
