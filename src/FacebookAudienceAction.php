<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\EnumExtractableTrait;

final class FacebookAudienceAction extends Enum
{

	use EnumExtractableTrait;

	public const UPDATE = 'update';

	public const REMOVE = 'remove';

}
