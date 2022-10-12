<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Comparable;

interface ComparableInterface
{

	/**
	 * @param mixed $that
	 */
	public function equals(
		$that
	): bool;

}
