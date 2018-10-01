<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\FloatExtractableTrait;

final class SigmoidValue implements ToStringInterface
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
		if ($value < -1 || $value > 1) {
			throw new InvalidTypeException('Invalid sigmoid value: ' . $value);
		}

		$this->value = $value;
	}

	public function getValue(): float
	{
		return $this->value;
	}

}
