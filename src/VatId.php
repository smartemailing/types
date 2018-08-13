<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Enum\InvalidEnumValueException;
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
	 * @var \SmartEmailing\Types\Country|null
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

	private function __construct(string $vatId)
	{
		[$this->country, $this->prefix, $this->vatNumber] = self::extractCountryAndPrefixAndNumber($vatId);

		if (!self::validate($this->country, $this->prefix, $this->vatNumber)) {
			throw new InvalidTypeException('VatId: ' . $this->getValue() . ' is not valid.');
		}
	}

	private static function parseCountryOrNull(string $vatId): ?Country
	{
		$countryCode = Strings::substring($vatId, 0, 2);

		if ($countryCode === 'EL') {
			$countryCode = Country::GR;
		}

		if ($countryCode === 'GY') {
			$countryCode = Country::GG;
		}

		try {
			return Country::from($countryCode);
		} catch (InvalidEnumValueException $e) {
			return null;
		}
	}

	private static function parsePrefixOrNull(?Country $country, string $vatId): ?string
	{
		if (!$country) {
			return null;
		}

		return Strings::substring($vatId, 0, 2);
	}

	private static function parseVatNumber(?Country $country, string $vatId): string
	{
		return $country ? Strings::substring($vatId, 2) : $vatId;
	}

	public static function isValid(string $vatId): bool
	{
		[$country, $countryPrefix, $vatNumber] = self::extractCountryAndPrefixAndNumber($vatId);
		return self::validate($country, $countryPrefix, $vatNumber);
	}

	private static function validate(?Country $country, ?string $prefix, string $vatNumber): bool
	{
		if ($country) {
			return self::isValidForCountry($country, $prefix, $vatNumber);
		}

		return self::isValidForNonCountry($vatNumber);
	}

	private static function isValidForCountry(Country $country, ?string $prefix, string $vatNumber): bool
	{
		$pattern = Arrays::get(self::getPatternsByCountry(), $country->getValue());

		$match = Strings::match($prefix . $vatNumber, '/^(' . $pattern . ')$/');
		if (!$match) {
			return false;
		}

		$modulo = Arrays::get(self::getDivisible(), $country->getValue(), 1);
		if (Validators::isNumericInt($vatNumber) && ($vatNumber % $modulo !== 0)) {
			return false;
		}

		return true;
	}

	/**
	 * @return string[]
	 */
	private static function getPatternsByCountry(): array
	{
		return [
			Country::AT => 'ATU\d{8}',
			Country::BE => 'BE[0-1]\d{9}',
			Country::BG => 'BG\d{9,10}',
			Country::HR => 'HR\d{11}',
			Country::CY => 'CY\d{8}[A-Z]',
			Country::CZ => 'CZ\d{8,10}',
			Country::DK => 'DK(\d{2}){3}(\d{2})',
			Country::EE => 'EE\d{9}',
			Country::FI => 'FI\d{8}',
			Country::FR => 'FR[A-Z0-9]{2}\d{9}',
			Country::DE => 'DE\d{9}',
			Country::GR => '(GR|EL)\d{9}',
			Country::HU => 'HU\d{8}',
			Country::IE => 'IE\d{7}[A-Z]{1,2}',
			Country::IT => 'IT\d{11}',
			Country::LV => 'LV\d{11}',
			Country::LT => 'LT(\d{9}|\d{12})',
			Country::LU => 'LU\d{8}',
			Country::MT => 'MT\d{8}',
			Country::NL => 'NL\d{9}B\d{2}',
			Country::PL => 'PL\d{10}',
			Country::PT => 'PT\d{9}',
			Country::RO => 'RO\d{2,10}',
			Country::SK => 'SK\d{10}',
			Country::SI => 'SI\d{8}',
			Country::ES => 'ES(([A-Z]\d{8})|([A-Z]\d{7}[A-Z]))',
			Country::SE => 'SE\d{12}',
			Country::CH => 'CHE\d{9}((MWST)|(TVA)|(IVA))',
			Country::GB => 'GB((\d{9})|(\d{12}))',
			Country::GG => 'GY\d{6}',
		];
	}

	/**
	 * @return int[]
	 */
	private static function getDivisible(): array
	{
		return [
			Country::SK => 11,
		];
	}

	private static function isValidForNonCountry(string $vatNumber): bool
	{
		return false; //todo
	}

	private static function preProcessVatId(string $vatId): string
	{
		$vatId = StringHelpers::removeWhitespace($vatId);
		return Strings::upper($vatId);
	}

	public function getCountry(): ?Country
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
	 * @return mixed[]
	 */
	private static function extractCountryAndPrefixAndNumber(string $vatId): array
	{
		$vatId = self::preProcessVatId($vatId);
		$country = self::parseCountryOrNull($vatId);
		$prefix = self::parsePrefixOrNull($country, $vatId);
		$vatNumber = self::parseVatNumber($country, $vatId);

		return [$country, $prefix, $vatNumber];
	}

}
