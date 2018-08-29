<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class PartTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$invalidValues = [
			'xxx',
			-2,
			100000,
			-0.01,
			1.1,
		];

		foreach ($invalidValues as $validValue) {
			Assert::throws(
				static function () use ($validValue): void {
					Part::from($validValue);
				},
				InvalidTypeException::class
			);
		}

		$part = Part::from(0);
		Assert::equal(0.0, $part->getValue());

		$part = Part::from(0.0);
		Assert::equal(0.0, $part->getValue());

		$part = Part::from(1);
		Assert::equal(1.0, $part->getValue());

		$part = Part::from(1.0);
		Assert::equal(1.0, $part->getValue());

		$part = Part::from(0.0003);
		Assert::equal(0.0003, $part->getValue());

		$part = Part::fromRatio(0.0, 0.0);
		Assert::equal(0.0, $part->getValue());

		$part = Part::fromRatio(1.0, 2.0);
		Assert::equal(0.5, $part->getValue());

		Assert::throws(
			static function (): void {
				Part::fromRatio(2.0, 1.0);
			},
			InvalidTypeException::class,
			'Value cannot be higher than whole: but 2 / 1 given.'
		);

		$part = Part::from(0.1234);
		Assert::equal(12.34, $part->getPercent());
	}

}

(new PartTest())->run();
