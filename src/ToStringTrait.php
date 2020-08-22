<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

trait ToStringTrait
{

	public function __toString(): string
	{
		return (string) $this->getValue();
	}

}
