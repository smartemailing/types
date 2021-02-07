<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;

require __DIR__ . '/bootstrap.php';

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
	'Tel:  +421 903 111 111' => CountryCode::SK,
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
	Assert::equal($country, $phone->getCountry()->getValue());
}
