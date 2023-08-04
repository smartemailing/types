<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\FloatExtractableTrait;

final class UnsignedFloat implements ToStringInterface, ComparableInterface
{

	use FloatExtractableTrait;
	use ToStringTrait;
	use StringComparableTrait;

	public function __construct(
		private float $value
	) {
		if ($value < 0.0 || $value > \PHP_INT_MAX) {
			throw new InvalidTypeException('Invalid unsigned float: ' . $value);
		}
	}

	public function getValue(): float
	{
		return $this->value;
	}

}
