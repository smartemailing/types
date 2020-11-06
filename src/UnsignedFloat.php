<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\FloatExtractableTrait;

final class UnsignedFloat implements ToStringInterface
{

	use FloatExtractableTrait;
	use ToStringTrait;

	/**
	 * @var float
	 */
	private $value;

	public function __construct(
		float $value
	) {
		if ($value < 0.0 || $value > \PHP_INT_MAX) {
			throw new InvalidTypeException('Invalid unsigned float: ' . $value);
		}

		$this->value = $value;
	}

	public function getValue(): float
	{
		return $this->value;
	}

}
