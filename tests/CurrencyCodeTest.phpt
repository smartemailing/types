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

		Assert::equal('EUR', $currencyEur->getValue());

		$currencyCzk = CurrencyCode::extractOrNull(['currency_code' => 'CZK'], 'currency_code');
		Assert::type(CurrencyCode::class, $currencyCzk);
		Assert::equal('CZK', $currencyCzk->getValue());

		$currencyPln = CurrencyCode::extract(['currency_code' => 'PLN'], 'currency_code');
		Assert::equal('PLN', $currencyPln->getValue());
		Assert::equal('PLN', (string) $currencyPln);

		Assert::true($currencyPln->equalsValue(CurrencyCode::PLN));
		Assert::false($currencyPln->equals($currencyCzk));

		$enums = CurrencyCode::getAvailableEnums();

		$enum = \reset($enums);
		Assert::type(CurrencyCode::class, $enum);
		Assert::equal('CZK', $enum->getValue());

		$values = CurrencyCode::getAvailableValues();

		$value = \reset($values);
		Assert::equal('CZK', $value);

		Assert::noError(static fn () => CurrencyCode::from('CZK'));

		Assert::exception(static function (): void {
			CurrencyCode::from('test');
		}, InvalidTypeException::class);
	}

}

(new CurrencyCodeTest())->run();
