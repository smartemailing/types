<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Strings;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class PhoneNumber implements ToStringInterface
{

	use StringExtractableTrait;
	use ToStringTrait;

	/**
	 * @var \SmartEmailing\Types\CountryCode
	 */
	private $country;

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @var array<int>
	 */
	private static $countryCodesToPhoneCodes = [
		CountryCode::SI => 386,
		CountryCode::MH => 692,
		CountryCode::CZ => 420,
		CountryCode::SK => 421,
		CountryCode::CY => 357,
		CountryCode::IE => 353,
		CountryCode::FI => 358,
		CountryCode::LU => 352,
		CountryCode::AT => 43,
		CountryCode::BE => 32,
		CountryCode::FR => 33,
		CountryCode::HU => 36,
		CountryCode::GB => 44,
		CountryCode::DE => 49,
		CountryCode::PL => 48,
		CountryCode::IT => 39,
		CountryCode::SE => 46,
		CountryCode::NL => 31,
		CountryCode::DK => 45,
		CountryCode::US => 1,
		CountryCode::TR => 90,
		CountryCode::IL => 972,
	];

	/**
	 * @var array<array<int>>
	 */
	private static $phoneNumberLengths = [
		CountryCode::CZ => [9],
		CountryCode::SK => [9],
		CountryCode::AT => [10, 11],
		CountryCode::BE => [9],
		CountryCode::FR => [9],
		CountryCode::HU => [9],
		CountryCode::GB => [10],
		CountryCode::DE => [10, 11],
		CountryCode::US => [10],
		CountryCode::PL => [9],
		CountryCode::IT => [9, 10, 12, 13],
		CountryCode::SE => [7],
		CountryCode::SI => [9],
		CountryCode::MH => [7],
		CountryCode::NL => [9],
		CountryCode::CY => [8],
		CountryCode::IE => [9],
		CountryCode::DK => [8],
		CountryCode::FI => [10],
		CountryCode::LU => [9],
		CountryCode::TR => [10],
		CountryCode::IL => [9],
	];

	private function __construct(
		string $value
	)
	{
		if (!$this->initialize($value)) {
			throw new InvalidTypeException('Invalid phone number: ' . $value);
		}
	}

	public function getCountry(): CountryCode
	{
		return $this->country;
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public static function preprocess(
		string $value
	): string
	{
		$value = Strings::replace(
			$value,
			[
				'~\(0\)~' => '',
			]
		);

		$value = Strings::replace(
			$value,
			[
				'~[^0-9\+]~' => '',
			]
		);

		if (Strings::startsWith($value, '00')) {
			$value = '+' . Strings::substring($value, 2);
		}

		return $value;
	}

	private function initialize(
		string $value
	): bool
	{
		$value = self::preprocess($value);

		$matchingCountryCodes = $this->getMatchingCountryCodes(
			$value
		);

		foreach ($matchingCountryCodes as $matchingCountryCode) {
			$match = $this->matchLengthForCountry(
				$matchingCountryCode,
				$value
			);

			if ($match) {
				$this->value = $value;
				$this->country = CountryCode::from($matchingCountryCode);

				return true;
			}
		}

		return false;
	}

	private function matchLengthForCountry(
		string $countryCode,
		string $value
	): bool
	{
		$afterCountryCode = (string) Strings::after(
			$value,
			(string) self::$countryCodesToPhoneCodes[$countryCode]
		);

		if (!\ctype_digit($afterCountryCode)) {
			return false;
		}

		$lenght = Strings::length($afterCountryCode);

		return \in_array(
			$lenght,
			self::$phoneNumberLengths[$countryCode],
			true
		);
	}

	/**
	 * @param string $value
	 * @return array<string> matching country code constants
	 */
	private function getMatchingCountryCodes(
		string $value
	): array
	{
		$matching = [];

		foreach (self::$countryCodesToPhoneCodes as $countryCode => $phoneCode) {
			$prefix = '+' . $phoneCode;

			if (!Strings::startsWith($value, $prefix)) {
				continue;
			}

			$matching[] = $countryCode;
		}

		return $matching;
	}

}
