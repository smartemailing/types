<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class PositiveIntTest extends TestCase
{

	public function test1(): void
	{
		$invalidValues = [
			'xxx',
			-2,
			-1,
			0,
			-0.2,
			0.1,
		];

		foreach ($invalidValues as $validValue) {
			Assert::throws(
				static function () use ($validValue): void {
					echo 'Testing ' . \var_export($validValue, true) . \PHP_EOL;
					PositiveInt::from($validValue);
				},
				InvalidTypeException::class
			);
		}

		Assert::noError(static fn () => PositiveInt::from(1));
		Assert::noError(static fn () => PositiveInt::from(1_000_000));

		Assert::equal(20, PositiveInt::from(20)->getValue());
		Assert::equal('20', (string) PositiveInt::from(20));
	}

}

(new PositiveIntTest())->run();
