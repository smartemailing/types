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
	 * @return static
	 */
	final public static function from(
		$data
	) {
		if ($data instanceof self) {
			return $data;
		}

		$data = IntType::from($data);

		return new static($data);
	}

}
