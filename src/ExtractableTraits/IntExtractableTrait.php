<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

use SmartEmailing\Types\PrimitiveTypes;

trait IntExtractableTrait
{

	use ExtractableTrait;

	abstract public function __construct(
		int $value
	);

	final public static function from(
		mixed $data
	): self {
		if ($data instanceof self) {
			return $data;
		}

		$data = PrimitiveTypes::getInt($data);

		return new static($data);
	}

}
