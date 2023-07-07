<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class PriceTest extends TestCase
{

	public function test1(): void
	{
		$data = [
			'with_vat' => 432.1,
			'without_vat' => '123.45',
			'currency' => CurrencyCode::CZK,
		];

		$price = Price::from($data);
		Assert::type(Price::class, $price);
		Assert::type('float', $price->getWithoutVat());
		Assert::type('float', $price->getWithVat());

		Assert::equal(CurrencyCode::CZK, $price->getCurrency()->getValue());

		Assert::type('array', $price->toArray());

		Assert::throws(
			static function (): void {
				Price::from([]);
			},
			InvalidTypeException::class
		);
	}

	public function test2(): void
	{
		$data = [
			'with_vat' => 242,
			'without_vat' => 200,
			'currency' => CurrencyCode::CZK,
		];

		$price = Price::from($data);

		$vatRate = $price->calculateVatRatePercent();

		Assert::equal(21.0, $vatRate);
	}

}

(new PriceTest())->run();
