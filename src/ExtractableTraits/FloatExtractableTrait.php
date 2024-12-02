<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

use SmartEmailing\Types\FloatType;

trait FloatExtractableTrait
{

	use ExtractableTrait;

	final public static function from(
		mixed $data
	): static
	{
		if ($data instanceof self) {
			return $data;
		}

		$data = FloatType::from($data);

		return new static($data);
	}

	abstract public function __construct(
		float $value
	);

}
