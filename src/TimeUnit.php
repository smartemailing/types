<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\EnumExtractableTrait;

final class TimeUnit extends Enum implements ToStringInterface
{

	use ObjectMixinTrait;
	use EnumExtractableTrait;
	use ToStringTrait;

	public const SECONDS = 'seconds';

	public const MINUTES = 'minutes';

	public const HOURS = 'hours';

	public const DAYS = 'days';

	public const WEEKS = 'weeks';

	public const MONTHS = 'months';

	public const YEARS = 'years';

}
