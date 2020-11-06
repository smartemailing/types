<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\EnumExtractableTrait;

final class Relation extends Enum
{

	use EnumExtractableTrait;

	public const AND = 'AND';

	public const OR = 'OR';

}
