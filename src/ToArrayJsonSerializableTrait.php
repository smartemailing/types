<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

trait ToArrayJsonSerializableTrait
{

	/**
	 * @return array<mixed>
	 */
	public function jsonSerialize(): array
	{
		return $this->toArray();
	}

}
