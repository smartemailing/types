<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\EnumExtractableTrait;

/**
 * ISO-4217 three-letter ("Alpha-3")
 */
final class CurrencyCode extends Enum implements ToStringInterface
{

	use EnumExtractableTrait;
	use ObjectMixinTrait;
	use ToStringTrait;

	public const CZK = 'CZK';

	public const EUR = 'EUR';

	public const AFN = 'AFN';

	public const ALL = 'ALL';

	public const DZD = 'DZD';

	public const USD = 'USD';

	public const AOA = 'AOA';

	public const XCD = 'XCD';

	public const ARS = 'ARS';

	public const AMD = 'AMD';

	public const AWG = 'AWG';

	public const AUD = 'AUD';

	public const AZN = 'AZN';

	public const BSD = 'BSD';

	public const BHD = 'BHD';

	public const BDT = 'BDT';

	public const BBD = 'BBD';

	public const BYN = 'BYN';

	public const BZD = 'BZD';

	public const XOF = 'XOF';

	public const BMD = 'BMD';

	public const INR = 'INR';

	public const BTN = 'BTN';

	public const BOB = 'BOB';

	public const BOV = 'BOV';

	public const BAM = 'BAM';

	public const BWP = 'BWP';

	public const NOK = 'NOK';

	public const BRL = 'BRL';

	public const BND = 'BND';

	public const BGN = 'BGN';

	public const BIF = 'BIF';

	public const CVE = 'CVE';

	public const KHR = 'KHR';

	public const XAF = 'XAF';

	public const CAD = 'CAD';

	public const KYD = 'KYD';

	public const CLP = 'CLP';

	public const CLF = 'CLF';

	public const CNY = 'CNY';

	public const COP = 'COP';

	public const COU = 'COU';

	public const KMF = 'KMF';

	public const CDF = 'CDF';

	public const NZD = 'NZD';

	public const CRC = 'CRC';

	public const HRK = 'HRK';

	public const CUP = 'CUP';

	public const CUC = 'CUC';

	public const ANG = 'ANG';

	public const DKK = 'DKK';

	public const DJF = 'DJF';

	public const DOP = 'DOP';

	public const EGP = 'EGP';

	public const SVC = 'SVC';

	public const ERN = 'ERN';

	public const ETB = 'ETB';

	public const FKP = 'FKP';

	public const FJD = 'FJD';

	public const XPF = 'XPF';

	public const GMD = 'GMD';

	public const GEL = 'GEL';

	public const GHS = 'GHS';

	public const GIP = 'GIP';

	public const GTQ = 'GTQ';

	public const GBP = 'GBP';

	public const GNF = 'GNF';

	public const GYD = 'GYD';

	public const HTG = 'HTG';

	public const HNL = 'HNL';

	public const HKD = 'HKD';

	public const HUF = 'HUF';

	public const ISK = 'ISK';

	public const IDR = 'IDR';

	public const XDR = 'XDR';

	public const IRR = 'IRR';

	public const IQD = 'IQD';

	public const ILS = 'ILS';

	public const JMD = 'JMD';

	public const JPY = 'JPY';

	public const JOD = 'JOD';

	public const KZT = 'KZT';

	public const KES = 'KES';

	public const KPW = 'KPW';

	public const KRW = 'KRW';

	public const KWD = 'KWD';

	public const KGS = 'KGS';

	public const LAK = 'LAK';

	public const LBP = 'LBP';

	public const LSL = 'LSL';

	public const ZAR = 'ZAR';

	public const LRD = 'LRD';

	public const LYD = 'LYD';

	public const CHF = 'CHF';

	public const MOP = 'MOP';

	public const MKD = 'MKD';

	public const MGA = 'MGA';

	public const MWK = 'MWK';

	public const MYR = 'MYR';

	public const MVR = 'MVR';

	public const MRU = 'MRU';

	public const MUR = 'MUR';

	public const XUA = 'XUA';

	public const MXN = 'MXN';

	public const MXV = 'MXV';

	public const MDL = 'MDL';

	public const MNT = 'MNT';

	public const MAD = 'MAD';

	public const MZN = 'MZN';

	public const MMK = 'MMK';

	public const NAD = 'NAD';

	public const NPR = 'NPR';

	public const NIO = 'NIO';

	public const NGN = 'NGN';

	public const OMR = 'OMR';

	public const PKR = 'PKR';

	public const PAB = 'PAB';

	public const PGK = 'PGK';

	public const PYG = 'PYG';

	public const PEN = 'PEN';

	public const PHP = 'PHP';

	public const PLN = 'PLN';

	public const QAR = 'QAR';

	public const RON = 'RON';

	public const RUB = 'RUB';

	public const RWF = 'RWF';

	public const SHP = 'SHP';

	public const WST = 'WST';

	public const STN = 'STN';

	public const SAR = 'SAR';

	public const RSD = 'RSD';

	public const SCR = 'SCR';

	public const SLL = 'SLL';

	public const SGD = 'SGD';

	public const XSU = 'XSU';

	public const SBD = 'SBD';

	public const SOS = 'SOS';

	public const SSP = 'SSP';

	public const LKR = 'LKR';

	public const SDG = 'SDG';

	public const SRD = 'SRD';

	public const SZL = 'SZL';

	public const SEK = 'SEK';

	public const CHE = 'CHE';

	public const CHW = 'CHW';

	public const SYP = 'SYP';

	public const TWD = 'TWD';

	public const TJS = 'TJS';

	public const TZS = 'TZS';

	public const THB = 'THB';

	public const TOP = 'TOP';

	public const TTD = 'TTD';

	public const TND = 'TND';

	public const TRY = 'TRY';

	public const TMT = 'TMT';

	public const UGX = 'UGX';

	public const UAH = 'UAH';

	public const AED = 'AED';

	public const USN = 'USN';

	public const UYU = 'UYU';

	public const UYI = 'UYI';

	public const UZS = 'UZS';

	public const VUV = 'VUV';

	public const VEF = 'VEF';

	public const VND = 'VND';

	public const YER = 'YER';

	public const ZMW = 'ZMW';

	public const ZWL = 'ZWL';

	public const XBA = 'XBA';

	public const XBB = 'XBB';

	public const XBC = 'XBC';

	public const XBD = 'XBD';

	public const XTS = 'XTS';

	public const XXX = 'XXX';

	public const XAU = 'XAU';

	public const XPD = 'XPD';

	public const XPT = 'XPT';

	public const XAG = 'XAG';

}
