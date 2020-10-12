<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\FloatExtractableTrait;

final class PositiveFloatOrZero implements ToStringInterface, ToFloatInterface
{

	use FloatExtractableTrait;
	use ToStringTrait;

	/**
	 * @var float
	 */
	private $value;

	public function __construct(float $value)
	{
		if ($value < 0.0) {
			throw new InvalidTypeException('Invalid positive float (excluded zero): ' . $value);
		}

		$this->value = $value;
	}

	public function getValue(): float
	{
		return $this->value;
	}

}
