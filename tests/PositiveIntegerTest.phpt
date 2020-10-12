<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\Helpers\NumberHelpers;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class PositiveIntegerTest extends TestCase
{

	use ObjectMixinTrait;

	public function testInvalidValue(): void
	{
		Assert::exception(
			static function (): void {
				PositiveInteger::from(-0.1);
			},
			InvalidTypeException::class
		);
	}

	public function testValidValue(): void
	{
		Assert::same(1, PositiveInteger::from(1)->getValue());

		Assert::same(1, NumberHelpers::getIntOrNull(PositiveInteger::from(1)));

		Assert::null(NumberHelpers::getIntOrNull(PositiveInteger::fromOrNull(null)));
	}

}

(new PositiveIntegerTest())->run();
