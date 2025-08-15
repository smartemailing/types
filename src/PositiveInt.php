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
	private int $value; // phpcs:ignore

	public function __construct(
		int $value
	) {
		if ($value < 1 || $value > \PHP_INT_MAX) {
			throw new InvalidTypeException('Invalid positive integer: ' . $value);
		}

		$this->value = $value;
	}

	/**
	 * @return positive-int
	 */
	public function getValue(): int
	{
		return $this->value;
	}

}
