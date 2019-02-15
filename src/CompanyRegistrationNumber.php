<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Nette\Utils\Strings;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class CompanyRegistrationNumber implements ToStringInterface
{

	use ObjectMixinTrait;
	use StringExtractableTrait;
	use ToStringTrait;

	/**
	 * @var string
	 */
	private $value;

	private function __construct(
		string $value
	) {
		Strings::trim($value);
		$value = (string) \preg_replace('/\s+/', '', $value);

		if (!$this->isValid($value)) {
			throw new InvalidTypeException('Invalid Company registration number: ' . $value);
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
		return $this->isValidCZSK($value) ||
			$this->isValidGB($value) ||
			$this->isValidCY($value) ||
			$this->isValidPL($value) ||
			$this->isValidUS($value) ||
			$this->isValidES($value);
	}

	private function isValidES(
		string $value
	): bool {
		$valueRegEx = '/^\d{8}[A-Z]$/i';
		$nieRegEx = '/^[XYZ]\d{7}[A-Z]$/i';
		$letters = 'TRWAGMYFPDXBNJZSQVHLCKE';

		if (\preg_match($valueRegEx, $value)) {
			return $letters[\substr($value, 0, 8) % 23] === $value[8];
		}

		if (\preg_match($nieRegEx, $value)) {
			if ($value[0] === 'X') {
				$value[0] = '0';
			} elseif ($value[0] === 'Y') {
				$value[0] = '1';
			} elseif ($value[0] === 'Z') {
				$value[0] = '2';
			}

			return $letters[\substr($value, 0, 8) % 23] === $value[8];
		}

		return false;
	}

	private function isValidCY(
		string $value
	): bool {
		return (bool) \preg_match(
			'~^HE(\d){6}$~',
			$value
		);
	}

	private function isValidGB(
		string $value
	): bool {
		return (bool) \preg_match(
			'~^([1-9]\d{6,7}|\d{6,7}|(SC|NI|AC|FC|GE|GN|GS|IC|IP|LP|NA|NF|NL|NO|NP|NR|NZ|OC|R|RC|SA|SF|SI|SL|SO|SP|SR|SZ|ZC|)\d{6,8})$~',
			$value
		);
	}

	private function isValidCZSK(
		string $value
	): bool {
		$value = (string) \preg_replace(
			'#\s+#',
			'',
			$value
		);

		if (!\preg_match('#^\d{8}$#', $value)) {
			return false;
		}

		$a = 0;

		for ($i = 0; $i < 7; $i++) {
			$a += $value[$i] * (8 - $i);
		}

		$a %= 11;

		if ($a === 0) {
			$c = 1;
		} elseif ($a === 1) {
			$c = 0;
		} else {
			$c = 11 - $a;
		}

		return ((int) $value[7]) === $c;
	}

	private function isValidPL(
		string $value
	): bool {
		$value = (string) \preg_replace(
			'#\s+#',
			'',
			$value
		);

		if (!\preg_match('#^\d{9}$#', $value)) {
			return false;
		}

		$digits = \str_split($value);
		$checksum = (
				8 * (int) $digits[0]
				+ 9 * (int) $digits[1]
				+ 2 * (int) $digits[2]
				+ 3 * (int) $digits[3]
				+ 4 * (int) $digits[4]
				+ 5 * (int) $digits[5]
				+ 6 * (int) $digits[6]
				+ 7 * (int) $digits[7]
			) % 11;

		if ($checksum === 10) {
			$checksum = 0;
		}

		return (int) $digits[8] === $checksum;
	}

	/**
	 * @param string $value
	 * @return bool
	 * @see https://en.wikipedia.org/wiki/Employer_Identification_Number
	 */
	private function isValidUS(
		string $value
	): bool {
		$value = (string) \preg_replace(
			'#\s+#',
			'',
			$value
		);

		if (!\preg_match('#^(\d{2})\-(\d{7})$#', $value, $matches)) {
			return false;
		}

		$prefix = (int) $matches[1];

		$allowedPrefixes = [
			10,
			12,
			60,
			67,
			50,
			53,
			01,
			02,
			03,
			04,
			05,
			06,
			11,
			13,
			14,
			16,
			21,
			22,
			23,
			25,
			34,
			51,
			52,
			54,
			55,
			56,
			57,
			58,
			59,
			65,
			30,
			32,
			35,
			36,
			37,
			38,
			61,
			15,
			24,
			40,
			44,
			94,
			95,
			80,
			90,
			33,
			39,
			41,
			42,
			43,
			48,
			62,
			63,
			64,
			66,
			68,
			71,
			72,
			73,
			74,
			75,
			76,
			77,
			82,
			83,
			84,
			85,
			86,
			87,
			88,
			91,
			92,
			93,
			98,
			99,
			20,
			26,
			27,
			45,
			46,
			47,
			81,
			31,
		];

		if (!\in_array($prefix, $allowedPrefixes, true)) {
			return false;
		}

		return Strings::length($matches[2]) === 7;
	}

}
