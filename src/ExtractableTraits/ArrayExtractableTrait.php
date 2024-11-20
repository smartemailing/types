<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

use SmartEmailing\Types\Arrays;

trait ArrayExtractableTrait
{

	use ExtractableTrait;

	/**
	 * @param array<mixed> $data
	 */
	abstract public function __construct(
		array $data
	);

	final public static function from(
		mixed $data
	): self {
		if ($data instanceof self) {
			return $data;
		}

		$data = Arrays::from($data);

		return new static($data);
	}

}
