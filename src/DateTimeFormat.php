<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;

abstract class DateTimeFormat
{

	use ObjectMixinTrait;

	public const DATE = 'Y-m-d';

	public const DATETIME = 'Y-m-d H:i:s';

}
