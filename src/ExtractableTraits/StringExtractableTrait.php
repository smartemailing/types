<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

use SmartEmailing\Types\StringType;

trait StringExtractableTrait
{

	use ExtractableTrait;

	final public static function from(
		mixed $data
	): static
	{
		if ($data instanceof self) {
			return $data;
		}

		$data = StringType::from($data);

		return new static($data);
	}

	abstract public function __construct(
		string $value
	);

}
