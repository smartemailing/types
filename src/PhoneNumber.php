<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Strings;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;
use SmartEmailing\Types\Helpers\CountryCodeToPhoneCodeTable;

final class PhoneNumber implements ToStringInterface
{

	use StringExtractableTrait;
	use ToStringTrait;

	private string $value;

	private function __construct(
		string $value
	)
	{
		$preprocessed = $this->initialize($value);

		if ($preprocessed === null) {
			throw new InvalidTypeException('Invalid phone number: ' . $value);
		}

		$this->value = $preprocessed;
	}

	public function guessCountry(): ?CountryCode
	{
		$input = CountryCodeToPhoneCodeTable::$countryCodesToPhoneCodes;

		\uasort(
			$input,
			static function (int $a, int $b) {
				return Strings::length((string) $b) <=> Strings::length((string) $a);
			}
		);

		$justNumbers = Strings::replace(
			$this->value,
			[
				'~[^\d]~' => '',
			]
		);

		foreach ($input as $countryCode => $dial) {
			if (Strings::startsWith($justNumbers, (string) $dial)) {
				return CountryCode::from($countryCode);
			}
		}

		return null;
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
				'~[\s\(\)\-]~' => '',
			]
		);

		if (Strings::startsWith($value, '00')) {
			$value = '+' . Strings::substring($value, 2);
		}

		return $value;
	}

	private function initialize(
		string $value
	): string | null
	{
		$value = self::preprocess($value);

		$match = \preg_match(
			'~^\+?[\d]{5,19}$~',
			$value,
			$m
		);

		if ($match !== 1) {
			return null;
		}

		return $value;
	}

}
