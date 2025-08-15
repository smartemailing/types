<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\IntExtractableTrait;

final class PositiveInt implements ToStringInterface, ComparableInterface
{

	use IntExtractableTrait;
	use ToStringTrait;
	use StringComparableTrait;

	/**
	 * @var positive-int
	 */
	private int $value;

	public function __construct(
		int $val
	) {
		if ($val < 1 || $val > \PHP_INT_MAX) {
			throw new InvalidTypeException('Invalid positive integer: ' . $val);
		}

		$this->value = $val;
	}

	/**
	 * @return positive-int
	 */
	public function getValue(): int
	{
		return $this->value;
	}

}
