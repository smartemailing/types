<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;

require __DIR__ . '/bootstrap.php';


$data = [
	'street_and_number' => 'Testovací 123',
	'town' => 'Želeč',
	'zip_code' => '391 74',
	'country' => 'CZ',
];

$normalizedData = [
	'street_and_number' => 'Testovací 123',
	'town' => 'Želeč',
	'zip_code' => '39174',
	'country' => 'CZ',
];

$address = Address::from($data);

Assert::equal(
	$normalizedData,
	\json_decode((string) \json_encode($address), true)
);
