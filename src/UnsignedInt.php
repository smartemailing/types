<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\IntExtractableTrait;

final class UnsignedInt implements ToStringInterface, ComparableInterface
{

	use IntExtractableTrait;
	use ToStringTrait;
	use StringComparableTrait;

	public function __construct(
		private int $value
	) {
		if ($value < 0 || $value > \PHP_INT_MAX) {
			throw new InvalidTypeException('Invalid unsigned integer: ' . $value);
		}
	}

	public function getValue(): int
	{
		return $this->value;
	}

}
