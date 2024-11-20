<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

use SmartEmailing\Types\StringType;

trait StringExtractableTrait
{

	use ExtractableTrait;

	abstract public function __construct(
		string $value
	);

	/**
	 * @param string|mixed|array<mixed> $data
	 */
	final public static function from(
		$data
	): self {
		if ($data instanceof self) {
			return $data;
		}

		$data = StringType::from($data);

		return new static($data);
	}

}
