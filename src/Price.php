<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;

final class Price
{

	use ArrayExtractableTrait;

	private float $withoutVat;

	private float $withVat;

	private CurrencyCode $currency;

	/**
	 * @param array<mixed> $data
	 */
	private function __construct(
		array $data
	) {
		$this->withoutVat = PrimitiveTypes::extractFloat($data, 'without_vat');
		$this->withVat = PrimitiveTypes::extractFloat($data, 'with_vat');
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
