<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class ReLUValueTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$invalidValues = [
			'xxx',
			-2,
		];

		foreach ($invalidValues as $validValue) {
			Assert::throws(
				static function () use ($validValue): void {
					ReLUValue::from($validValue);
				},
				InvalidTypeException::class
			);
		}

		$reLuValue = ReLUValue::from(0);
		Assert::equal(0.0, $reLuValue->getValue());

		$reLuValue = ReLUValue::from(0.0);
		Assert::equal(0.0, $reLuValue->getValue());

		$reLuValue = ReLUValue::from(1);
		Assert::equal(1.0, $reLuValue->getValue());

		$reLuValue = ReLUValue::from(1.0);
		Assert::equal(1.0, $reLuValue->getValue());
	}

}

(new ReLUValueTest())->run();
