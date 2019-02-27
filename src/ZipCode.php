<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Nette\Utils\Strings;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;
use SmartEmailing\Types\Helpers\StringHelpers;

final class ZipCode implements ToStringInterface
{

	use ObjectMixinTrait;
	use StringExtractableTrait;
	use ToStringTrait;

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @var string[]
	 */
	private static $patternsByCountry = [
		CountryCode::CZ => '#^\d{3}?\d{2}\z#',
		CountryCode::SK => '#^\d{3}?\d{2}\z#',
		CountryCode::AT => '#^\d{4}\z#',
		CountryCode::BE => '#^\d{4}\z#',
		CountryCode::FR => '#^\d{2}?\d{3}\z#',
		CountryCode::HU => '#^\d{4}\z#',
		CountryCode::GB => '#^GIR?0AA|(?:(?:AB|AL|B|BA|BB|BD|BH|BL|BN|BR|BS|BT|BX|CA|CB|CF|CH|CM|CO|CR|CT|CV|CW|DA|DD|DE|DG|DH|DL|DN|DT|DY|E|EC|EH|EN|EX|FK|FY|G|GL|GY|GU|HA|HD|HG|HP|HR|HS|HU|HX|IG|IM|IP|IV|JE|KA|KT|KW|KY|L|LA|LD|LE|LL|LN|LS|LU|M|ME|MK|ML|N|NE|NG|NN|NP|NR|NW|OL|OX|PA|PE|PH|PL|PO|PR|RG|RH|RM|S|SA|SE|SG|SK|SL|SM|SN|SO|SP|SR|SS|ST|SW|SY|TA|TD|TF|TN|TQ|TR|TS|TW|UB|W|WA|WC|WD|WF|WN|WR|WS|WV|YO|ZE)(?:\d[\dA-Z]??\d[ABD-HJLN-UW-Z]{2}))|BFPO?\d{1,4}\z#',
		CountryCode::DE => '#^\d{5}\z#',
		CountryCode::US => '#^(\d{5})(?:[\-](\d{4}))?\z#',
		CountryCode::PL => '#^\d{2}-\d{3}\z#',
		CountryCode::IT => '#^\d{5}\z#',
		CountryCode::SE => '#^\d{3}?\d{2}\z#',
		CountryCode::SI => '#^\d{4}\z#',
		CountryCode::MH => '#^(969[67]\d)(?:[\-](\d{4}))?\z#',
		CountryCode::NL => '#^\d{4}?[A-Z]{2}\z#',
		CountryCode::CY => '#^\d{4}\z#',
		CountryCode::IE => '#^[\dA-Z]{3}?[\dA-Z]{4}\z#',
		CountryCode::DK => '#^\d{4}\z#',
		CountryCode::FI => '#^\d{5}\z#',
		CountryCode::LU => '#^\d{4}\z#',
		CountryCode::MT => '#^[A-Z]{3}?\d{2,4}\z#',
	];

	private function __construct(
		string $value
	) {
		$value = StringHelpers::removeWhitespace($value);
		$value = Strings::upper($value);

		if (!$this->isValid($value)) {
			throw new InvalidTypeException('Invalid ZIP code: ' . $value);
		}

		$this->value = $value;
	}

	public function getValue(): string
	{
		return $this->value;
	}

	private function isValid(
		string $value
	): bool {
		foreach (self::$patternsByCountry as $pattern) {
			if (Strings::match($value, $pattern)) {
				return true;
			}
		}

		return false;
	}

}
