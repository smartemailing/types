<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\EnumExtractableTrait;

final class FieldOfApplication extends Enum
{

	use ObjectMixinTrait;
	use EnumExtractableTrait;

	public const CARS = 'cars';

	public const SAFETY = 'safety';

	public const TRAVEL = 'travel';

	public const TRANSPORT = 'transport';

	public const ESHOP = 'eshop';

	public const PHARMACY = 'pharmacy';

	public const FINANCIAL = 'financial';

	public const PHOTOGRAPHY = 'photography';

	public const HOTELS = 'hotels';

	public const COSMETICS = 'cosmetics';

	public const PERSONAL_DEVELOPMENT = 'personal-development';

	public const MARGETING = 'margeting';

	public const NON_PROFIT = 'non-profit';

	public const OTHER = 'other';

	public const FOOD = 'food';

	public const LAW = 'law';

	public const REAL_ESTATES = 'real-estates';

	public const CRAFT = 'craft';

	public const GARDEN = 'garden';

	public const IT = 'it';

	public const ARCHITECTURE = 'architecture';

	public const ENGINEERING = 'engineering';

	public const WHOLESALE = 'wholesale';

	public const PUBLIC_ADMINISTRATION = 'public-administration';

	public const PRODUCTION = 'production';

	public const EDUCATION = 'education';

	public const SLIM = 'slim';

	public const HEALTHCARE = 'healthcare';

	public const AGRICULTURE = 'agriculture';

}
