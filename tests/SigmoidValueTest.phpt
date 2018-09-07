<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class SigmoidValueTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$invalidValues = [
			'xxx',
			-2,
			100000,
			1.1,
		];

		foreach ($invalidValues as $validValue) {
			Assert::throws(
				static function () use ($validValue): void {
					SigmoidValue::from($validValue);
				},
				InvalidTypeException::class
			);
		}

		$sigmoidValue = SigmoidValue::from(0);
		Assert::equal(0.0, $sigmoidValue->getValue());

		$sigmoidValue = SigmoidValue::from(0.0);
		Assert::equal(0.0, $sigmoidValue->getValue());

		$sigmoidValue = SigmoidValue::from(1);
		Assert::equal(1.0, $sigmoidValue->getValue());

		$sigmoidValue = SigmoidValue::from(1.0);
		Assert::equal(1.0, $sigmoidValue->getValue());

		$sigmoidValue = SigmoidValue::from(-0.0003);
		Assert::equal(-0.0003, $sigmoidValue->getValue());

		$sigmoidValue = SigmoidValue::from(-1.0);
		Assert::equal(-1.0, $sigmoidValue->getValue());
	}

}

(new SigmoidValueTest())->run();
