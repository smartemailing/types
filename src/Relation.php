<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\EnumExtractableTrait;

final class Relation extends Enum
{

	use ObjectMixinTrait;
	use EnumExtractableTrait;

	public const AND = 'AND';

	public const OR = 'OR';

}
