<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\IntExtractableTrait;

final class PositiveIntegerOrZero implements ToStringInterface, ToIntInterface
{

	use IntExtractableTrait;
	use ToStringTrait;

	/**
	 * @var int
	 */
	private $value;

	public function __construct(int $value)
	{
		if ($value < 0) {
			throw new InvalidTypeException('Invalid positive integer (excluded zero): ' . $value);
		}

		$this->value = $value;
	}

	public function getValue(): int
	{
		return $this->value;
	}

}
