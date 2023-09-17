<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

trait GetValueJsonSerializableTrait
{

	public function jsonSerialize(): mixed
	{
		return $this->getValue();
	}

}
