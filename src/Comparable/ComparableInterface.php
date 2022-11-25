<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Comparable;

interface ComparableInterface
{

	public function equals(
		mixed $that
	): bool;

}
