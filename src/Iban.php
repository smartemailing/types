<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Iban\Validation\Validator;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class Iban implements ToStringInterface
{

	use ObjectMixinTrait;
	use StringExtractableTrait;
	use ToStringTrait;

	public const FORMAT_ELECTRONIC = 'electronic';
	public const FORMAT_PRINT = 'print';

	/**
	 * @var \Iban\Validation\Iban
	 */
	private $iban;

	/**
	 * @var string
	 */
	private $value;

	public function __construct(string $value)
	{
		$this->iban = new \Iban\Validation\Iban($value);
		$validator = new Validator();

		if (!$validator->validate($this->iban)) {
			throw new InvalidTypeException('Invalid Iban: ' . $value);
		}

		$this->value = $value;
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function getCountry(): CountryCode
	{
		return CountryCode::from($this->iban->getCountryCode());
	}

	public function getFormatted(string $type = self::FORMAT_ELECTRONIC): string
	{
		return $this->iban->format($type);
	}

	public function getChecksum(): int
	{
		return (int) $this->iban->getChecksum();
	}

}
