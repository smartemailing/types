<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

use SmartEmailing\Types\IntType;

trait IntExtractableTrait
{

	use ExtractableTrait;

	abstract public function __construct(
		int $value
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

		$data = IntType::from($data);

		return new static($data);
	}

}
