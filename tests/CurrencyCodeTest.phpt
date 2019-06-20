<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/bootstrap.php';

final class CurrencyCodeTest extends TestCase
{

	public function testDefault(): void
	{
		$currencyEur = CurrencyCode::from('EUR');
		$currencyEur = CurrencyCode::from($currencyEur);

		Assert::type(CurrencyCode::class, $currencyEur);
		Assert::equal('EUR', $currencyEur->getValue());

		$currencyCzk = CurrencyCode::extractOrNull(['currency_code' => 'CZK'], 'currency_code');
		Assert::equal('CZK', $currencyCzk->getValue());

		$currencyPln = CurrencyCode::extract(['currency_code' => 'PLN'], 'currency_code');
		Assert::equal('PLN', $currencyPln->getValue());
		Assert::equal('PLN', (string) $currencyPln);

		Assert::true($currencyPln->equalsValue(CurrencyCode::PLN));
		Assert::false($currencyPln->equals($currencyCzk));

		$enums = CurrencyCode::getAvailableEnums();
		Assert::type('array', $enums);

		$enum = \reset($enums);
		Assert::equal('CZK', $enum->getValue());
		Assert::type(CurrencyCode::class, $enum);

		$values = CurrencyCode::getAvailableValues();
		Assert::type('array', $values);

		$value = \reset($values);
		Assert::equal('CZK', $value);

		$country = CurrencyCode::from('CZK');
		Assert::type(CurrencyCode::class, $country);
		Assert::type(CurrencyCode::class, $country);

		Assert::exception(static function (): void {
			CurrencyCode::from('test');
		}, InvalidTypeException::class);
	}

}

(new CurrencyCodeTest())->run();
