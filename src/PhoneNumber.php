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
		Country::CZ => 420,
		Country::SK => 421,
		Country::AT => 43,
		Country::BE => 32,
		Country::FR => 33,
		Country::HU => 36,
		Country::GB => 44,
		Country::DE => 49,
		Country::US => 1,
		Country::PL => 48,
		Country::IT => 39,
		Country::SE => 46,
		Country::SI => 386,
		Country::MH => 692,
		Country::NL => 31,
		Country::CY => 357,
		Country::IE => 353,
		Country::DK => 45,
		Country::FI => 358,
		Country::LU => 352,
	];

	/**
	 * @var int[][]
	 */
	private static $phoneNumberLengths = [
		Country::CZ => [9],
		Country::SK => [9],
		Country::AT => [10, 11],
		Country::BE => [9],
		Country::FR => [9],
		Country::HU => [9],
		Country::GB => [10],
		Country::DE => [10, 11],
		Country::US => [10],
		Country::PL => [9],
		Country::IT => [9, 10, 12, 13],
		Country::SE => [7],
		Country::SI => [9],
		Country::MH => [7],
		Country::NL => [9],
		Country::CY => [6],
		Country::IE => [9],
		Country::DK => [8],
		Country::FI => [10],
		Country::LU => [9],
	];

	/**
	 * @var \SmartEmailing\Types\Country
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

	private function initilize(
		string $value
	): bool {
		$value = (string) \preg_replace(
			'/\s+/',
			'',
			$value
		);
		$value = (string) \preg_replace(
			'~\x{00a0}~',
			'',
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

				$this->country = Country::get($countryCode);
				$this->value = $value;
				return true;
			}
		}
		return false;
	}

	public function getCountry(): Country
	{
		return $this->country;
	}

	public function getValue(): string
	{
		return $this->value;
	}

}
