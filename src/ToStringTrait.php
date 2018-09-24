<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

trait ToStringTrait
{

	public function __toString(): string
	{
		$value = $this->getValue();

		if (\is_string($value)) {
			return $value;
		}

		return (string) $value;
	}

}
