<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/bootstrap.php';

final class CountryCodeTest extends TestCase
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

		Assert::noError(static fn () => CountryCode::from('CZ'));
	}

}

(new CountryCodeTest())->run();
