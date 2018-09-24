<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Nette\Utils\Arrays;
use Nette\Utils\Strings;
use Nette\Utils\Validators;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;
use SmartEmailing\Types\Helpers\StringHelpers;

final class VatId implements ToStringInterface
{

	use ObjectMixinTrait;
	use ToStringTrait;
	use StringExtractableTrait;

	/**
	 * @var \SmartEmailing\Types\CountryCode|null
	 */
	private $country;

	/**
	 * @var string|null
	 */
	private $prefix;

	/**
	 * @var string
	 */
	private $vatNumber;

	/**
	 * @var string[]
	 */
	private static $patternsByCountry = [
		CountryCode::AT => 'ATU\d{8}',
		CountryCode::BE => 'BE[0-1]\d{9}',
		CountryCode::BG => 'BG\d{9,10}',
		CountryCode::HR => 'HR\d{11}',
		CountryCode::CY => 'CY\d{8}[A-Z]',
		CountryCode::CZ => 'CZ\d{8,10}',
		CountryCode::DK => 'DK(\d{2}){3}(\d{2})',
		CountryCode::EE => 'EE\d{9}',
		CountryCode::FI => 'FI\d{8}',
		CountryCode::FR => 'FR[A-Z0-9]{2}\d{9}',
		CountryCode::DE => 'DE\d{9}',
		CountryCode::GR => '(GR|EL)\d{9}',
		CountryCode::HU => 'HU\d{8}',
		CountryCode::IE => 'IE\d{7}[A-Z]{1,2}',
		CountryCode::IT => 'IT\d{11}',
		CountryCode::LV => 'LV\d{11}',
		CountryCode::LT => 'LT(\d{9}|\d{12})',
		CountryCode::LU => 'LU\d{8}',
		CountryCode::MT => 'MT\d{8}',
		CountryCode::NL => 'NL\d{9}B\d{2}',
		CountryCode::PL => 'PL\d{10}',
		CountryCode::PT => 'PT\d{9}',
		CountryCode::RO => 'RO\d{2,10}',
		CountryCode::SK => 'SK\d{10}',
		CountryCode::SI => 'SI\d{8}',
		CountryCode::ES => 'ES(([A-Z]\d{8})|([A-Z]\d{7}[A-Z]))',
		CountryCode::SE => 'SE\d{12}',
		CountryCode::CH => 'CHE\d{9}((MWST)|(TVA)|(IVA))',
		CountryCode::GB => 'GB((\d{9})|(\d{12}))',
		CountryCode::GG => 'GY\d{6}',
	];

	private function __construct(string $vatId)
	{
		[$this->country, $this->prefix, $this->vatNumber] = self::extractCountryAndPrefixAndNumber($vatId);

		if (!self::validate($this->country, $this->prefix, $this->vatNumber)) {
			throw new InvalidTypeException('VatId: ' . $this->getValue() . ' is not valid.');
		}
	}

	private static function parseCountryOrNull(string $vatId): ?CountryCode
	{
		$countryCode = Strings::substring($vatId, 0, 2);

		if ($countryCode === 'EL') {
			$countryCode = CountryCode::GR;
		}

		if ($countryCode === 'GY') {
			$countryCode = CountryCode::GG;
		}

		try {
			return CountryCode::from($countryCode);
		} catch (InvalidTypeException $e) {
			return null;
		}
	}

	private static function parsePrefixOrNull(?CountryCode $country, string $vatId): ?string
	{
		if (!$country) {
			return null;
		}

		return Strings::substring($vatId, 0, 2);
	}

	private static function parseVatNumber(?CountryCode $country, string $vatId): string
	{
		return $country
			? Strings::substring($vatId, 2)
			: $vatId;
	}

	public static function isValid(string $vatId): bool
	{
		[$country, $countryPrefix, $vatNumber] = self::extractCountryAndPrefixAndNumber($vatId);

		return self::validate($country, $countryPrefix, $vatNumber);
	}

	private static function validate(?CountryCode $country, ?string $prefix, string $vatNumber): bool
	{
		if ($country) {
			return self::isValidForCountry($country, $prefix, $vatNumber);
		}

		return self::isValidForNonCountry($vatNumber);
	}

	private static function isValidForCountry(CountryCode $country, ?string $prefix, string $vatNumber): bool
	{
		$pattern = Arrays::get(self::getPatternsByCountry(), $country->getValue());

		$match = Strings::match($prefix . $vatNumber, '/^(' . $pattern . ')$/');

		if (!$match) {
			return false;
		}

		$modulo = Arrays::get(self::getDivisible(), $country->getValue(), 1);

		return !Validators::isNumericInt($vatNumber) || ($vatNumber % $modulo === 0);
	}

	/**
	 * @return string[]
	 */
	private static function getPatternsByCountry(): array
	{
		return self::$patternsByCountry;
	}

	/**
	 * @return int[]
	 */
	private static function getDivisible(): array
	{
		return [
			CountryCode::SK => 11,
		];
	}

	/**
	 * @param string $vatNumber
	 * @return bool
	 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
	 */
	private static function isValidForNonCountry(string $vatNumber): bool
	{
		return false;

		//todo
	}

	private static function preProcessVatId(string $vatId): string
	{
		$vatId = StringHelpers::removeWhitespace($vatId);

		return Strings::upper($vatId);
	}

	public function getCountry(): ?CountryCode
	{
		return $this->country;
	}

	public function getPrefix(): ?string
	{
		return $this->prefix;
	}

	public function getVatNumber(): string
	{
		return $this->vatNumber;
	}

	public function getValue(): string
	{
		return $this->prefix . $this->vatNumber;
	}

	/**
	 * @param string $vatId
	 * @return mixed[]
	 */
	private static function extractCountryAndPrefixAndNumber(
		string $vatId
	): array {
		$vatId = self::preProcessVatId($vatId);
		$country = self::parseCountryOrNull($vatId);
		$prefix = self::parsePrefixOrNull($country, $vatId);
		$vatNumber = self::parseVatNumber($country, $vatId);

		return [$country, $prefix, $vatNumber];
	}

}
