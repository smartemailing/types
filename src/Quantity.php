<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\IntExtractableTrait;

final class Quantity implements ToStringInterface, ComparableInterface, \JsonSerializable
{

	use IntExtractableTrait;
	use ToStringTrait;
	use StringComparableTrait;

	public function __construct(
		private readonly int $value
	) {
		if ($value < 1 || $value > \PHP_INT_MAX) {
			throw new InvalidTypeException('Invalid quantity: ' . $value);
		}
	}

	public function getValue(): int
	{
		return $this->value;
	}

}
