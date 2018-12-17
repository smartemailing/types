<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class PhoneNumberTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$invalidValues = [
			'720182158',
			'+720182158',
			'+42072018215',
			'+4207201821580',
			'+42072018215a',
			'xxx',
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					PhoneNumber::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			'+420720182158' => CountryCode::CZ,
			'+391234567891234' => CountryCode::IT,
			'+905322002020' => CountryCode::TR,
			'+972546589568' => CountryCode::IL,
		];

		foreach ($validValues as $number => $country) {
			$phone = PhoneNumber::from($number);
			Assert::type(PhoneNumber::class, $phone);
			Assert::equal($country, $phone->getCountry()->getValue());
			Assert::equal($number, $phone->getValue());
			Assert::equal($number, (string) $phone);
		}
	}

}

(new PhoneNumberTest())->run();
