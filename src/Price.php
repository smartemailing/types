<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Comparable\ArrayComparableTrait;
use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;

final class Price implements ToArrayInterface, ComparableInterface
{

	use ArrayExtractableTrait;
	use ArrayComparableTrait;

	private float $withoutVat;

	private float $withVat;

	private CurrencyCode $currency;

	/**
	 * @param array<mixed> $data
	 */
	private function __construct(
		array $data
	)
	{
		$this->withoutVat = FloatType::extract($data, 'without_vat');
		$this->withVat = FloatType::extract($data, 'with_vat');
		$this->currency = CurrencyCode::extract($data, 'currency');
	}

	public function getWithoutVat(): float
	{
		return $this->withoutVat;
	}

	public function getWithVat(): float
	{
		return $this->withVat;
	}

	public function getCurrency(): CurrencyCode
	{
		return $this->currency;
	}

	public function calculateVatRatePercent(): float
	{
		return \round(($this->withVat / $this->withoutVat - 1) * 100, 3);
	}

	/**
	 * @return array<mixed>
	 */
	public function toArray(): array
	{
		return [
			'without_vat' => $this->withoutVat,
			'with_vat' => $this->withVat,
			'currency' => $this->currency->getValue(),
		];
	}

}
