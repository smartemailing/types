<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class AddressTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$data = [
			'street_and_number' => 'Testovací 123',
			'town' => 'Želeč',
			'zip_code' => '391 74',
			'country' => 'CZ',
		];

		$address = Address::from($data);
		Assert::type(Address::class, $address);
		Assert::type(ZipCode::class, $address->getZipCode());
		Assert::type(Country::class, $address->getCountry());

		Assert::throws(
			function (): void {
				Address::from([]);
			},
			InvalidTypeException::class
		);
	}

}

(new AddressTest())->run();
