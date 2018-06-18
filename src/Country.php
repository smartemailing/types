<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\EnumExtractableTrait;

/**
 * Class Country
 * @package SmartEmailing\Types
 *
 * ISO-3166-1 Alpha 2 country code enum
 * @see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
 *
 */
final class Country extends Enum
{

	use ObjectMixinTrait;
	use EnumExtractableTrait;

	// Czech Republic
	public const CZ = 'CZ';

	// Slovak Republic
	public const SK = 'SK';

	/// Austria
	public const AT = 'AT';

	/// Belgium
	public const BE = 'BE';

	/// France
	public const FR = 'FR';

	/// Hungary
	public const HU = 'HU';

	// Great Britain
	public const GB = 'GB';

	// Germany
	public const DE = 'DE';

	// United States
	public const US = 'US';

	// Poland
	public const PL = 'PL';

	// Italia
	public const IT = 'IT';

	// Sweden
	public const SE = 'SE';

	// Slovenia
	public const SI = 'SI';

	// Marstall Islands
	public const MH = 'MH';

	// Netherlands
	public const NL = 'NL';

	// Cyprus
	public const CY = 'CY';

	// Ireland
	public const IE = 'IE';

	// Denmark
	public const DK = 'DK';

	// Finland
	public const FI = 'FI';

	// Luxembourg
	public const LU = 'LU';

	// Malta
	public const MT = 'MT';

	// Seychelles
	public const SC = 'SC';

	/// Switzerland
	public const CH = 'CH';

	// Australia
	public const AU = 'AU';

	// Canada
	public const CA = 'CA';

	// Turkey
	public const TR = 'TR';

	// Chile
	public const CL = 'CL';

	// Taiwan, Province of China
	public const TW = 'TW';

	// Spain
	public const ES = 'ES';

}
