<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\EnumExtractableTrait;

final class TimeUnit extends Enum
{

	use ObjectMixinTrait;
	use EnumExtractableTrait;
	use ToStringTrait;

	public const HOURS = 'hours';

	public const DAYS = 'days';

	public const WEEKS = 'weeks';

	public const MONTHS = 'months';

	public const YEARS = 'years';

}
