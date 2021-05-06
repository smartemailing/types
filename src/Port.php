<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\IntExtractableTrait;

final class Port implements ToStringInterface
{

	use IntExtractableTrait;
	use ToStringTrait;

	private int $value;

	public function __construct(
		int $value
	) {
		if ($value < 0 || $value > 65535) {
			throw new InvalidTypeException('Invalid Port number: ' . $value);
		}

		$this->value = $value;
	}

	public function getValue(): int
	{
		return $this->value;
	}

}
