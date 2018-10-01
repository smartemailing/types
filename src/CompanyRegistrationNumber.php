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
			$this->isValidCY($value);
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
