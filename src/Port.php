<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\IntExtractableTrait;

final class Port implements ToStringInterface, ComparableInterface
{

	use IntExtractableTrait;
	use ToStringTrait;
	use StringComparableTrait;

	public function __construct(
		private int $value
	) {
		if ($value < 0 || $value > 65535) {
			throw new InvalidTypeException('Invalid Port number: ' . $value);
		}
	}

	public function getValue(): int
	{
		return $this->value;
	}

}
