<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class PortTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{

		$invalidValues = [
			'xxx',
			-2,
			100000,
		];

		foreach ($invalidValues as $validValue) {
			Assert::throws(
				function () use ($validValue) : void {
					Port::from($validValue);
				},
				InvalidTypeException::class
			);
		}

		Assert::type(Port::class, Port::from(0));
		Assert::type(Port::class, Port::from(65535));
		Assert::type(Port::class, Port::from(20));
	}

}

(new PortTest())->run();