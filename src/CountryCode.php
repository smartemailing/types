<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\EnumExtractableTrait;

/**
 * ISO-3166-1 Alpha 2 country code enum
 *
 * @see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
 */
final class CountryCode extends Enum implements ToStringInterface
{

	use EnumExtractableTrait;
	use ToStringTrait;

	//  Afghanistan
	public const AF = 'AF';

	//  Albania
	public const AL = 'AL';

	//  Algeria
	public const DZ = 'DZ';

	//  American Samoa
	public const AS = 'AS';

	//  Andorra
	public const AD = 'AD';

	//  Angola
	public const AO = 'AO';

	//  Anguilla
	public const AI = 'AI';

	//  Antarctica
	public const AQ = 'AQ';

	//  Argentina
	public const AR = 'AR';

	//  Armenia
	public const AM = 'AM';

	//  Aruba
	public const AW = 'AW';

	//  Australia
	public const AU = 'AU';

	//  Austria
	public const AT = 'AT';

	//  Azerbaijan
	public const AZ = 'AZ';

	//  Bahamas
	public const BS = 'BS';

	//  Bahrain
	public const BH = 'BH';

	//  Bangladesh
	public const BD = 'BD';

	//  Barbados
	public const BB = 'BB';

	//  Belarus
	public const BY = 'BY';

	//  Belgium
	public const BE = 'BE';

	//  Belize
	public const BZ = 'BZ';

	//  Benin
	public const BJ = 'BJ';

	//  Bermuda
	public const BM = 'BM';

	//  Bhutan
	public const BT = 'BT';

	//  Bolivia
	public const BO = 'BO';

	//  Bosnia and Herzegovina
	public const BA = 'BA';

	//  Botswana
	public const BW = 'BW';

	//  Brazil
	public const BR = 'BR';

	//  British Virgin Islands
	public const VG = 'VG';

	//  Brunei
	public const BN = 'BN';

	//  Bulgaria
	public const BG = 'BG';

	//  Burkina Faso
	public const BF = 'BF';

	//  Burundi
	public const BI = 'BI';

	//  Cambodia
	public const KH = 'KH';

	//  Cameroon
	public const CM = 'CM';

	//  Canada
	public const CA = 'CA';

	//  Cape Verde
	public const CV = 'CV';

	//  Cayman Islands
	public const KY = 'KY';

	//  Central African Republic
	public const CF = 'CF';

	//  Chile
	public const CL = 'CL';

	//  China
	public const CN = 'CN';

	//  Colombia
	public const CO = 'CO';

	//  Comoros
	public const KM = 'KM';

	//  Cook Islands
	public const CK = 'CK';

	//  Costa Rica
	public const CR = 'CR';

	//  Croatia
	public const HR = 'HR';

	//  Cuba
	public const CU = 'CU';

	//  Curacao
	public const CW = 'CW';

	//  Cyprus
	public const CY = 'CY';

	//  Czech Republic
	public const CZ = 'CZ';

	//  Democratic Republic of Congo
	public const CD = 'CD';

	//  Denmark
	public const DK = 'DK';

	//  Djibouti
	public const DJ = 'DJ';

	//  Dominica
	public const DM = 'DM';

	//  Dominican Republic
	public const DO = 'DO';

	//  East Timor
	public const TL = 'TL';

	//  Ecuador
	public const EC = 'EC';

	//  Egypt
	public const EG = 'EG';

	//  El Salvador
	public const SV = 'SV';

	//  Equatorial Guinea
	public const GQ = 'GQ';

	//  Eritrea
	public const ER = 'ER';

	//  Estonia
	public const EE = 'EE';

	//  Ethiopia
	public const ET = 'ET';

	//  Falkland Islands
	public const FK = 'FK';

	//  Faroe Islands
	public const FO = 'FO';

	//  Fiji
	public const FJ = 'FJ';

	//  Finland
	public const FI = 'FI';

	//  France
	public const FR = 'FR';

	//  French Polynesia
	public const PF = 'PF';

	//  Gabon
	public const GA = 'GA';

	//  Gambia
	public const GM = 'GM';

	//  Georgia
	public const GE = 'GE';

	//  Germany
	public const DE = 'DE';

	//  Ghana
	public const GH = 'GH';

	//  Gibraltar
	public const GI = 'GI';

	//  Greece
	public const GR = 'GR';

	//  Greenland
	public const GL = 'GL';

	//  Guadeloupe
	public const GP = 'GP';

	//  Guam
	public const GU = 'GU';

	//  Guatemala
	public const GT = 'GT';

	//  Guinea
	public const GN = 'GN';

	//  Guinea-Bissau
	public const GW = 'GW';

	//  Guyana
	public const GY = 'GY';

	//  Haiti
	public const HT = 'HT';

	//  Honduras
	public const HN = 'HN';

	//  Hong Kong
	public const HK = 'HK';

	//  Hungary
	public const HU = 'HU';

	//  Iceland
	public const IS = 'IS';

	//  India
	public const IN = 'IN';

	//  Indonesia
	public const ID = 'ID';

	//  Iran
	public const IR = 'IR';

	//  Iraq
	public const IQ = 'IQ';

	//  Ireland
	public const IE = 'IE';

	//  Isle of Man
	public const IM = 'IM';

	//  Israel
	public const IL = 'IL';

	//  Italy
	public const IT = 'IT';

	//  Ivory Coast
	public const CI = 'CI';

	//  Jamaica
	public const JM = 'JM';

	//  Japan
	public const JP = 'JP';

	//  Jordan
	public const JO = 'JO';

	//  Kazakhstan
	public const KZ = 'KZ';

	//  Kenya
	public const KE = 'KE';

	//  Kiribati
	public const KI = 'KI';

	//  Kosovo
	public const XK = 'XK';

	//  Kuwait
	public const KW = 'KW';

	//  Kyrgyzstan
	public const KG = 'KG';

	//  Laos
	public const LA = 'LA';

	//  Latvia
	public const LV = 'LV';

	//  Lebanon
	public const LB = 'LB';

	//  Lesotho
	public const LS = 'LS';

	//  Liberia
	public const LR = 'LR';

	//  Libya
	public const LY = 'LY';

	//  Liechtenstein
	public const LI = 'LI';

	//  Lithuania
	public const LT = 'LT';

	//  Luxembourg
	public const LU = 'LU';

	//  Macau
	public const MO = 'MO';

	//  Macedonia
	public const MK = 'MK';

	//  Madagascar
	public const MG = 'MG';

	//  Malawi
	public const MW = 'MW';

	//  Malaysia
	public const MY = 'MY';

	//  Maldives
	public const MV = 'MV';

	//  Mali
	public const ML = 'ML';

	//  Malta
	public const MT = 'MT';

	//  Marshall Islands
	public const MH = 'MH';

	//  Mauritania
	public const MR = 'MR';

	//  Mauritius
	public const MU = 'MU';

	//  Mexico
	public const MX = 'MX';

	//  Micronesia
	public const FM = 'FM';

	//  Moldova
	public const MD = 'MD';

	//  Monaco
	public const MC = 'MC';

	//  Mongolia
	public const MN = 'MN';

	//  Montenegro
	public const ME = 'ME';

	//  Montserrat
	public const MS = 'MS';

	//  Morocco
	public const MA = 'MA';

	//  Mozambique
	public const MZ = 'MZ';

	//  Myanmar [Burma]
	public const MM = 'MM';

	//  Namibia
	public const NA = 'NA';

	//  Nauru
	public const NR = 'NR';

	//  Nepal
	public const NP = 'NP';

	//  Netherlands
	public const NL = 'NL';

	//  New Caledonia
	public const NC = 'NC';

	//  New Zealand
	public const NZ = 'NZ';

	//  Nicaragua
	public const NI = 'NI';

	//  Niger
	public const NE = 'NE';

	//  Nigeria
	public const NG = 'NG';

	//  Niue
	public const NU = 'NU';

	//  Norfolk Island
	public const NF = 'NF';

	//  North Korea
	public const KP = 'KP';

	//  Northern Mariana Islands
	public const MP = 'MP';

	//  Norway
	public const NO = 'NO';

	//  Oman
	public const OM = 'OM';

	//  Pakistan
	public const PK = 'PK';

	//  Palau
	public const PW = 'PW';

	//  Panama
	public const PA = 'PA';

	//  Papua New Guinea
	public const PG = 'PG';

	//  Paraguay
	public const PY = 'PY';

	//  Peru
	public const PE = 'PE';

	//  Philippines
	public const PH = 'PH';

	//  Pitcairn Islands
	public const PN = 'PN';

	//  Poland
	public const PL = 'PL';

	//  Portugal
	public const PT = 'PT';

	//  Puerto Rico
	public const PR = 'PR';

	//  Qatar
	public const QA = 'QA';

	//  Republic of the Congo
	public const CG = 'CG';

	//  Reunion
	public const RE = 'RE';

	//  Romania
	public const RO = 'RO';

	//  Russia
	public const RU = 'RU';

	//  Rwanda
	public const RW = 'RW';

	//  Saint Barthélemy
	public const BL = 'BL';

	//  Saint Helena
	public const SH = 'SH';

	//  Saint Kitts and Nevis
	public const KN = 'KN';

	//  Saint Lucia
	public const LC = 'LC';

	//  Saint Martin
	public const MF = 'MF';

	//  Saint Pierre and Miquelon
	public const PM = 'PM';

	//  Saint Vincent and the Grenadines
	public const VC = 'VC';

	//  Samoa
	public const WS = 'WS';

	//  San Marino
	public const SM = 'SM';

	//  Sao Tome and Principe
	public const ST = 'ST';

	//  Saudi Arabia
	public const SA = 'SA';

	//  Senegal
	public const SN = 'SN';

	//  Serbia
	public const RS = 'RS';

	//  Seychelles
	public const SC = 'SC';

	//  Sierra Leone
	public const SL = 'SL';

	//  Singapore
	public const SG = 'SG';

	//  Slovakia
	public const SK = 'SK';

	//  Slovenia
	public const SI = 'SI';

	//  Solomon Islands
	public const SB = 'SB';

	//  Somalia
	public const SO = 'SO';

	//  South Africa
	public const ZA = 'ZA';

	//  South Korea
	public const KR = 'KR';

	//  South Sudan
	public const SS = 'SS';

	//  Spain
	public const ES = 'ES';

	//  Sri Lanka
	public const LK = 'LK';

	//  Sudan
	public const SD = 'SD';

	//  Suriname
	public const SR = 'SR';

	//  Swaziland
	public const SZ = 'SZ';

	//  Sweden
	public const SE = 'SE';

	//  Switzerland
	public const CH = 'CH';

	//  Syria
	public const SY = 'SY';

	//  Taiwan
	public const TW = 'TW';

	//  Tajikistan
	public const TJ = 'TJ';

	//  Tanzania
	public const TZ = 'TZ';

	//  Thailand
	public const TH = 'TH';

	//  Togo
	public const TG = 'TG';

	//  Tokelau
	public const TK = 'TK';

	//  Trinidad and Tobago
	public const TT = 'TT';

	//  Tunisia
	public const TN = 'TN';

	//  Turkey
	public const TR = 'TR';

	//  Turkmenistan
	public const TM = 'TM';

	//  Tuvalu
	public const TV = 'TV';

	//  Uganda
	public const UG = 'UG';

	//  Ukraine
	public const UA = 'UA';

	//  United Arab Emirates
	public const AE = 'AE';

	//  United Kingdom
	public const GB = 'GB';

	//  United States
	public const US = 'US';

	//  Uruguay
	public const UY = 'UY';

	//  Uzbekistan
	public const UZ = 'UZ';

	//  Vanuatu
	public const VU = 'VU';

	//  Vatican
	public const VA = 'VA';

	//  Venezuela
	public const VE = 'VE';

	//  Vietnam
	public const VN = 'VN';

	//  Western Sahara
	public const EH = 'EH';

	//  Yemen
	public const YE = 'YE';

	//  Zambia
	public const ZM = 'ZM';

	//  Zimbabwe
	public const ZW = 'ZW';

	// Guernsey
	public const GG = 'GG';

}
