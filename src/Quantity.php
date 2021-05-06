<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\IntExtractableTrait;

final class Quantity implements ToStringInterface
{

	use IntExtractableTrait;
	use ToStringTrait;

	private int $value;

	public function __construct(
		int $value
	) {
		if ($value < 1 || $value > \PHP_INT_MAX) {
			throw new InvalidTypeException('Invalid quantity: ' . $value);
		}

		$this->value = $value;
	}

	public function getValue(): int
	{
		return $this->value;
	}

}
