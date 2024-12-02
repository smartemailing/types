<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

use SmartEmailing\Types\IntType;

trait IntExtractableTrait
{

	use ExtractableTrait;

	final public static function from(
		mixed $data
	): static
	{
		if ($data instanceof self) {
			return $data;
		}

		$data = IntType::from($data);

		return new static($data);
	}

	abstract public function __construct(
		int $value
	);

}
