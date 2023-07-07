<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

class PhoneNumberTest extends TestCase
{

	public function testInvalidValues(): void
	{
		$invalidValues = [
			'Tel:  +421 903 111 111',
			'abcd',
			'++720182158',
			'+42072274957503260901821580',
			'+42072018215a',
			'xxx',
		];

		foreach ($invalidValues as $invalidValue) {

			Assert::throws(
				static function () use ($invalidValue): void {
					PhoneNumber::from($invalidValue);
					echo 'FAIL, ' . $invalidValue . ' should be invalid.' . \PHP_EOL;
				},
				InvalidTypeException::class
			);
		}
	}

	public function testValidValues(): void
	{
		$validValues = [
			'+385915809952' => CountryCode::HR,
			'+420(608)111111' => CountryCode::CZ,
			'00421 254111111' => CountryCode::SK,
			'00421 905 111 111' => CountryCode::SK,
			'+420 950 111 111' => CountryCode::CZ,
			'+420720182158' => CountryCode::CZ,
			'+391234567891234' => CountryCode::IT,
			'+905322002020' => CountryCode::TR,
			'+972546589568' => CountryCode::IL,
			'+35796562049' => CountryCode::CY,
		];

		foreach ($validValues as $number => $country) {
			$phone = PhoneNumber::from($number);
			Assert::type(PhoneNumber::class, $phone);
			Assert::type(CountryCode::class, $phone->guessCountry());
			Assert::equal(
				$country,
				$phone->guessCountry()
				->getValue()
			);
			echo 'Phone number '
				. $phone->getValue()
				. ' belongs to '
				. $phone->guessCountry()
				->getValue()
				. \PHP_EOL;
		}
	}

}
(new PhoneNumberTest())->run();
