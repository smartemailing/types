<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/bootstrap.php';

class CountryCodeTest extends TestCase
{

	public function testDefaults(): void
	{
		$countrySK = CountryCode::from('SK');
		Assert::equal('SK', $countrySK->getValue());

		$countryGB = CountryCode::extractOrNull(['currency_code' => 'GB'], 'currency_code');
		Assert::type(CountryCode::class, $countryGB);
		Assert::equal('GB', $countryGB->getValue());

		$countryPL = CountryCode::extract(['currency_code' => 'PL'], 'currency_code');
		Assert::equal('PL', $countryPL->getValue());
		Assert::equal('PL', (string) $countryPL);

		Assert::true($countryPL->equalsValue(CountryCode::PL));
		Assert::false($countryPL->equals($countryGB));

		$enums = CountryCode::getAvailableEnums();
		Assert::type('array', $enums);

		$values = CountryCode::getAvailableValues();
		Assert::type('array', $values);

		$country = CountryCode::from('CZ');
		Assert::type(CountryCode::class, $country);
		Assert::type(CountryCode::class, $country);
	}

}

(new CountryCodeTest())->run();
