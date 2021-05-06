<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\FloatExtractableTrait;

final class Part implements ToStringInterface
{

	use FloatExtractableTrait;
	use ToStringTrait;

	private float $value;

	public function __construct(
		float $value
	) {
		if ($value < 0 || $value > 1) {
			throw new InvalidTypeException('Invalid part: ' . $value);
		}

		$this->value = $value;
	}

	public static function fromRatio(
		float $value,
		float $whole
	): self {
		if ($value > $whole) {
			throw new InvalidTypeException(
				'Value cannot be higher than whole: but '
				. $value
				. ' / '
				. $whole
				. ' given.'
			);
		}

		if ($whole === 0.0) {
			return new static(0.0);
		}

		return new static($value / $whole);
	}

	public function getValue(): float
	{
		return $this->value;
	}

	public function getPercent(): float
	{
		return $this->getValue() * 100;
	}

}
