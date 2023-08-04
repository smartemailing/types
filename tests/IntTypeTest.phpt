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
		];

		foreach ($invalid as $value) {
			Assert::throws(
				static function () use ($value) {
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
			1.00000,
			'1.00000',
		];

		foreach ($invalid as $value) {
			echo 'Trying valid: ' . \var_export($value, true) . \PHP_EOL;
			Assert::true(
				\is_int(IntType::from($value))
			);
		}
	}

}

(new IntTypeTest())->run();
