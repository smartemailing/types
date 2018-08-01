<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class Iban implements ToStringInterface
{

	use ObjectMixinTrait;
	use StringExtractableTrait;
	use ToStringTrait;

	/**
	 * @var \IBAN\Core\IBAN
	 */
	private $iban;

	/**
	 * @var string
	 */
	private $value;

	public function __construct(string $value)
	{
		$this->iban = new \IBAN\Core\IBAN($value);
		if (!$this->iban->validate()) {
			throw new InvalidTypeException('Invalid Iban: ' . $value);
		}
		$this->value = $value;
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function getCountry(): Country
	{
		return Country::from($this->iban->getLocaleCode());
	}

	public function getFormatted(): string
	{
		return $this->iban->format();
	}

	public function getChecksum(): int
	{
		return (int) $this->iban->getChecksum();
	}

	public function getAccountIdentification(): string
	{
		return $this->iban->getAccountIdentification();
	}

	public function getInstituteIdentification(): string
	{
		return $this->iban->getInstituteIdentification();
	}

	public function getBankAccountNumber(): string
	{
		return $this->iban->getBankAccountNumber();
	}

}
