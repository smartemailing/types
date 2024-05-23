<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

interface ToStringInterface extends \Stringable
{

	public function __toString(): string;

}
