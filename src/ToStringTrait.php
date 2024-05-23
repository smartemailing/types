<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

trait ToStringTrait
{

	use GetValueJsonSerializableTrait;

	public function __toString(): string
	{
		return (string) $this->getValue();
	}

}
