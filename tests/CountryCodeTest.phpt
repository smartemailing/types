<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

final class CountryCodeTest extends \Tester\TestCase
{

	public function testDefault(): void
	{
		$countrySK = CountryCode::from('SK');
		Assert::equal('SK', $countrySK->getValue());

		$countryGB = CountryCode::extractOrNull(['currency_code' => 'GB'], 'currency_code');
		Assert::equal('GB', $countryGB->getValue());

		$countryPL = CountryCode::extract(['currency_code' => 'PL'], 'currency_code');
		Assert::equal('PL', $countryPL->getValue());
		Assert::equal('PL', (string) $countryPL);

		Assert::true($countryPL->equalsValue(CountryCode::PL));
		Assert::false($countryPL->equals($countryGB));

		$enums = CountryCode::getAvailableEnums();
		Assert::type('array', $enums);

		$enum = \reset($enums);
		Assert::equal('CZ', $enum->getValue());
		Assert::type(CountryCode::class, $enum);

		$values = CountryCode::getAvailableValues();
		Assert::type('array', $values);

		$value = \reset($values);
		Assert::equal('CZ', $value);

		$country = CountryCode::from('CZ');
		Assert::type(CountryCode::class, $country);
		Assert::type(CountryCode::class, $country);
	}

}

(new CountryCodeTest())->run();
