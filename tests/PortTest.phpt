<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class PortTest extends TestCase
{

	public function test1(): void
	{
		$invalidValues = [
			'xxx',
			-2,
			100_000,
		];

		foreach ($invalidValues as $validValue) {
			Assert::throws(
				static function () use ($validValue): void {
					Port::from($validValue);
				},
				InvalidTypeException::class
			);
		}

		Assert::noError(static fn () => Port::from(0));
		Assert::noError(static fn () => Port::from(65_535));
		Assert::noError(static fn () => Port::from(20));

		Assert::equal(20, Port::from(20)->getValue());
		Assert::equal('20', (string) Port::from(20));
	}

}

(new PortTest())->run();
