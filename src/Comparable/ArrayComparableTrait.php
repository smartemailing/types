<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Comparable;

use SmartEmailing\Types\ToArrayInterface;

trait ArrayComparableTrait
{

	/**
	 * @return array<mixed>
	 */
	abstract public function toArray(): array;

	public function equals(
		mixed $that
	): bool {
		return $this instanceof ToArrayInterface
			&& $that instanceof ToArrayInterface
			&& \get_class($that) === static::class
			&& $this->toArray() === $that->toArray();
	}

}
