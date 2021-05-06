<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

use SmartEmailing\Types\PrimitiveTypes;

trait FloatExtractableTrait
{

	use ExtractableTrait;

	abstract public function __construct(
		float $value
	);

	final public static function from(
		mixed $data,
		mixed ...$params
	): self {
		if ($data instanceof self) {
			return $data;
		}

		$data = PrimitiveTypes::getFloat($data);

		return new static($data);
	}

}
