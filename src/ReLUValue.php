<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\FloatExtractableTrait;

final class ReLUValue implements ToStringInterface, ComparableInterface, \JsonSerializable
{

	use FloatExtractableTrait;
	use ToStringTrait;
	use StringComparableTrait;

	public function __construct(
		private readonly float $value
	) {
		if ($value < 0.0) {
			throw new InvalidTypeException('Invalid ReLU value: ' . $value);
		}
	}

	public function getValue(): float
	{
		return $this->value;
	}

}
