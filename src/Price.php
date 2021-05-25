<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;

final class Price
{

	use ArrayExtractableTrait;

	/**
	 * @var float
	 */
	private $withoutVat;

	/**
	 * @var float
	 */
	private $withVat;

	/**
	 * @var \SmartEmailing\Types\CurrencyCode
	 */
	private $currency;

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
