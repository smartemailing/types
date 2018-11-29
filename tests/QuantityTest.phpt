<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class QuantityTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$invalidValues = [
			'xxx',
			-2,
			0,
		];

		foreach ($invalidValues as $validValue) {
			Assert::throws(
				static function () use ($validValue): void {
					Quantity::from($validValue);
				},
				InvalidTypeException::class
			);
		}

		Assert::type(Quantity::class, Quantity::from(1));
		Assert::type(Quantity::class, Quantity::from(1000000));

		Assert::equal(20, Quantity::from(20)->getValue());
		Assert::equal('20', (string) Quantity::from(20));
	}

}

(new QuantityTest())->run();
