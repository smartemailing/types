<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class UnsignedFloatTest extends TestCase
{

	public function test1(): void
	{
		$invalidValues = [
			'xxx',
			-2,
			-1,
			-0.1,
		];

		foreach ($invalidValues as $validValue) {
			Assert::throws(
				static function () use ($validValue): void {
					UnsignedFloat::from($validValue);
				},
				InvalidTypeException::class
			);
		}

		Assert::type(UnsignedFloat::class, UnsignedFloat::from(1));
		Assert::type(UnsignedFloat::class, UnsignedFloat::from(1000000.0));

		Assert::equal(20.0, UnsignedFloat::from(20)->getValue());
		Assert::equal('20', (string) UnsignedFloat::from(20));

		Assert::equal(0.125, UnsignedFloat::from(0.125)->getValue());
		Assert::equal('0.125', (string) UnsignedFloat::from(0.125));
	}

}

(new UnsignedFloatTest())->run();
