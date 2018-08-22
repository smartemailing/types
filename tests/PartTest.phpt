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
				function () use ($validValue): void {
					Part::from($validValue);
				},
				InvalidTypeException::class
			);
		}

		Assert::type(Part::class, Part::from(0));
		Assert::type(Part::class, Part::from(0.0));
		Assert::type(Part::class, Part::from(1.0));
		Assert::type(Part::class, Part::from(1));
		Assert::type(Part::class, Part::from(0.0003));
	}

}

(new PartTest())->run();
