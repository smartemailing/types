<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Nette\Utils\Strings;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class CompanyRegistrationNumber
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
		return
			$this->isValidCZSK($value) ||
			$this->isValidGB($value) ||
			$this->isValidDE($value) ||
			$this->isValidCY($value);
	}

	private function isValidDE(
		string $value
	): bool {
		$value = (string) \preg_replace(
			'/\D/',
			'',
			$value
		);

		if (\strlen($value) !== 11) {
			return false;
		}

		if ($value[0] === '0') {
			return false;
		}

		/*
		 make sure that within the first ten digits:
			 1.) one digit appears exactly twice or thrice
			 2.) one or two digits appear zero times
			 3.) and oll other digits appear exactly once once
		*/
		$digits = \str_split($value);
		$first10Digits = $digits;
		\array_pop($first10Digits);
		$countDigits = \count(\array_count_values($first10Digits));
		if ($countDigits !== 9 && $countDigits !== 8) {
			return false;
		}

		// last check: 11th digit has to be the correct checkums
		// see http://de.wikipedia.org/wiki/Steueridentifikationsnummer#Aufbau_der_Identifikationsnummer
		$product = 10;
		for ($i = 0; $i <= 9; $i++) {
			$sum = ($digits[$i] + $product) % 10;
			if ($sum === 0) {
				$sum = 10;
			}
			$product = ($sum * 2) % 11;
		}
		$checksum = 11 - $product;
		if ($checksum === 10) {
			$checksum = 0;
		}

		return $value[10] === $checksum;
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

}
