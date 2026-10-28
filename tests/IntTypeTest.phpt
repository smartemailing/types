<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class IntTypeTest extends TestCase
{

	public function testInvalid(): void
	{
		$invalid = [
			true,
			false,
			null,
			new class {

},
			[],
			'x',
			1.001,
			'1.001',
			9_223_372_036_854_775_808.0,
			-1.0e19,
			1.0e30,
			'100000000000000000000.0',
			\NAN,
			\INF,
			-\INF,
		];

		foreach ($invalid as $value) {
			Assert::throws(
				static function () use ($value): void {
					echo 'Trying invalid: ' . \var_export($value, true) . \PHP_EOL;
					IntType::from($value);
				},
				InvalidTypeException::class
			);
		}
	}

	public function testValid(): void
	{
		$invalid = [
			1,
			'1',
			1.000_00,
			'1.00000',
			-1,
			-1.0,
			'-1.0',
		];

		foreach ($invalid as $value) {
			echo 'Trying valid: ' . \var_export($value, true) . \PHP_EOL;
			Assert::noError(static fn () => IntType::from($value));
		}
	}

	public function testRangeBoundaries(): void
	{
		Assert::same(\PHP_INT_MAX, IntType::from(\PHP_INT_MAX));
		Assert::same(\PHP_INT_MIN, IntType::from(\PHP_INT_MIN));
		Assert::same(\PHP_INT_MIN, IntType::from((float) \PHP_INT_MIN));
		Assert::same(9_007_199_254_740_992, IntType::from(9_007_199_254_740_992.0));
	}

}

(new IntTypeTest())->run();
