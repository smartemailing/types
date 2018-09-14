<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Nette\Utils\Strings;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class PhoneNumber
{

	use ObjectMixinTrait;
	use StringExtractableTrait;
	use ToStringTrait;

	/**
	 * @var int[]
	 */
	private static $phoneCodes = [
		CountryCode::CZ => 420,
		CountryCode::SK => 421,
		CountryCode::AT => 43,
		CountryCode::BE => 32,
		CountryCode::FR => 33,
		CountryCode::HU => 36,
		CountryCode::GB => 44,
		CountryCode::DE => 49,
		CountryCode::US => 1,
		CountryCode::PL => 48,
		CountryCode::IT => 39,
		CountryCode::SE => 46,
		CountryCode::SI => 386,
		CountryCode::MH => 692,
		CountryCode::NL => 31,
		CountryCode::CY => 357,
		CountryCode::IE => 353,
		CountryCode::DK => 45,
		CountryCode::FI => 358,
		CountryCode::LU => 352,
	];

	/**
	 * @var int[][]
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
		CountryCode::CY => [6],
		CountryCode::IE => [9],
		CountryCode::DK => [8],
		CountryCode::FI => [10],
		CountryCode::LU => [9],
	];

	/**
	 * @var \SmartEmailing\Types\CountryCode
	 */
	private $country;

	/**
	 * @var string
	 */
	private $value;

	private function __construct(string $value)
	{
		if (!$this->initilize($value)) {
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

	private function initilize(
		string $value
	): bool {
		$value = $this->preprocessValue(
			$value
		);

		foreach (self::$phoneCodes as $countryCode => $phoneCode) {

			$prefix = '+' . $phoneCode;

			if (!Strings::startsWith($value, $prefix)) {
				continue;
			}

			$plainNumber = Strings::after($value, $prefix);

			if (!\ctype_digit($plainNumber)) {
				return false;
			}

			$plainNumberLength = Strings::length($value) - Strings::length($prefix);

			foreach (self::$phoneNumberLengths[$countryCode] as $phoneNumberLength) {
				if ($phoneNumberLength !== $plainNumberLength) {
					continue;
				}

				$this->country = CountryCode::get($countryCode);
				$this->value = $value;
				return true;
			}
		}
		return false;
	}

	private function preprocessValue(
		string $value
	): string {
		$value = (string) \preg_replace(
			'/\s+/',
			'',
			$value
		);
		return (string) \preg_replace(
			'~\x{00a0}~',
			'',
			$value
		);
	}

}
