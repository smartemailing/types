<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\Country;
use SmartEmailing\Types\InvalidTypeException;
use SmartEmailing\Types\PhoneNumber;
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
				function () use ($invalidValue) {
					PhoneNumber::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			'+420720182158' => Country::CZ,
			'+391234567891234' => Country::IT,
		];

		foreach ($validValues as $number => $country) {
			$phone = PhoneNumber::from($number);
			Assert::type(PhoneNumber::class, $phone);
			Assert::equal($country, $phone->getCountry()->getValue());
		}
	}

}

(new PhoneNumberTest())->run();