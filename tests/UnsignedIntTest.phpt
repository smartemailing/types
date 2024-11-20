<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class UnsignedIntTest extends TestCase
{

	public function test1(): void
	{
		$invalidValues = [
			'xxx',
			-2,
			-1,
			-0.2,
			0.1,
		];

		foreach ($invalidValues as $validValue) {
			Assert::throws(
				static function () use ($validValue): void {
					echo 'Testing ' . \var_export($validValue, true) . \PHP_EOL;
					UnsignedInt::from($validValue);
				},
				InvalidTypeException::class
			);
		}

		Assert::noError(static fn () => UnsignedInt::from(1));
		Assert::noError(static fn () => UnsignedInt::from(1_000_000));

		Assert::equal(20, UnsignedInt::from(20)->getValue());
		Assert::equal('20', (string) UnsignedInt::from(20));
	}

}

(new UnsignedIntTest())->run();
