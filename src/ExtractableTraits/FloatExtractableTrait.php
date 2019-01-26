<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

use SmartEmailing\Types\PrimitiveTypes;

trait FloatExtractableTrait
{

	use ExtractableTrait;

	abstract public function __construct(float $value);

	/**
	 * @param string|mixed|mixed[] $data
	 * @return self
	 */
	final public static function from(
		$data
	): self {
		if ($data instanceof self) {
			return $data;
		}

		$data = PrimitiveTypes::getFloat($data);

		return new static($data);
	}

}
