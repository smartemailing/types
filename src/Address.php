<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Comparable\ArrayComparableTrait;
use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;

final class Address implements ToArrayInterface, ComparableInterface
{

	use ArrayExtractableTrait;
	use ArrayComparableTrait;

	private string $streetAndNumber;

	private string $town;

	private ZipCode $zipCode;

	private CountryCode $country;

	/**
	 * @param array<mixed> $data
	 */
	private function __construct(
		array $data
	) {
		$this->streetAndNumber = StringType::extract($data, 'street_and_number');
		$this->town = StringType::extract($data, 'town');
		$this->zipCode = ZipCode::extract($data, 'zip_code');
		$this->country = CountryCode::extract($data, 'country');
	}

	/**
	 * @return array<mixed>
	 */
	public function toArray(): array
	{
		return [
			'street_and_number' => $this->streetAndNumber,
			'town' => $this->town,
			'zip_code' => $this->zipCode->getValue(),
			'country' => $this->country->getValue(),
		];
	}

	public function getStreetAndNumber(): string
	{
		return $this->streetAndNumber;
	}

	public function getTown(): string
	{
		return $this->town;
	}

	public function getZipCode(): ZipCode
	{
		return $this->zipCode;
	}

	public function getCountry(): CountryCode
	{
		return $this->country;
	}

}
