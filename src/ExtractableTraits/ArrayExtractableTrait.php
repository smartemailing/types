<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

use SmartEmailing\Types\Arrays;

trait ArrayExtractableTrait
{

	use ExtractableTrait;

	/**
	 * @param mixed[] $data
	 */
	abstract public function __construct(array $data);

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

		$data = Arrays::getArray($data);

		return new static($data);
	}

}
