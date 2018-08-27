<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\FloatExtractableTrait;

final class Part
{

	use ObjectMixinTrait;
	use FloatExtractableTrait;
	use ToStringTrait;

	/**
	 * @var float
	 */
	private $value;

	public function __construct(
		float $value
	) {
		if ($value < 0 || $value > 1) {
			throw new InvalidTypeException('Invalid part: ' . $value);
		}
		$this->value = $value;
	}

	public function getValue(): float
	{
		return $this->value;
	}

}
