<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class QuantityTest extends TestCase
{

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

		Assert::noError(static fn () => Quantity::from(1));
		Assert::noError(static fn () => Quantity::from(1_000_000));

		Assert::equal(20, Quantity::from(20)->getValue());
		Assert::equal('20', (string) Quantity::from(20));
	}

}

(new QuantityTest())->run();
