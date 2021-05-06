<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\FloatExtractableTrait;

final class ReLUValue implements ToStringInterface
{

	use FloatExtractableTrait;
	use ToStringTrait;

	private float $value;

	public function __construct(
		float $value
	) {
		if ($value < 0.0) {
			throw new InvalidTypeException('Invalid ReLU value: ' . $value);
		}

		$this->value = $value;
	}

	public function getValue(): float
	{
		return $this->value;
	}

}
