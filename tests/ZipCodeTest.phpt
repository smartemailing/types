<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class ZipCodeTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$invalidValues = [
			'dssdssdsd',
			'd7c8539e-089e-11e8-b161-2edbc134be21-12',
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					ZipCode::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			'39174',
			'72528',
			'E11DU',
		];

		foreach ($validValues as $validValue) {
			$zip = ZipCode::from($validValue);
			Assert::type(ZipCode::class, $zip);
			Assert::equal($validValue, $zip->getValue());
		}

		Assert::equal('39174', ZipCode::extract($validValues, 0, countryCode: CountryCode::from(CountryCode::CZ))->getValue());

		Assert::exception(
			static fn () => ZipCode::extract($validValues, 0, countryCode: CountryCode::from(CountryCode::GB)),
			InvalidTypeException::class
		);

		Assert::equal('WC2N5DU', ZipCode::from('WC2N 5DU')->getValue());

		Assert::equal('W22LW', ZipCode::from('w2 2lw')->getValue());

		Assert::equal('WC2N5DU', ZipCode::from('WC2N 5DU', countryCode: CountryCode::from(CountryCode::GB))->getValue());

		Assert::exception(
			static fn () => ZipCode::from('WC2N 5DU', countryCode: CountryCode::from(CountryCode::SK)),
			InvalidTypeException::class
		);
	}

}

(new ZipCodeTest())->run();
