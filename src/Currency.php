<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Enum\Enum;
use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\EnumExtractableTrait;

final class Currency extends Enum
{

	use EnumExtractableTrait;
	use ObjectMixinTrait;

	public const CZK = 'CZK';

	public const EUR = 'EUR';

}
