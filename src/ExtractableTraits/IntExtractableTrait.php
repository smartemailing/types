<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\ExtractableTrait;

trait IntExtractableTrait
{

	use ExtractableTrait;

	abstract public function __construct(int $value);

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
		$data = PrimitiveTypes::getInt($data);
		return new self($data);
	}

}
