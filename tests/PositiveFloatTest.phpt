<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\Helpers\NumberHelpers;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class PositiveFloatTest extends TestCase
{

	use ObjectMixinTrait;

	public function testInvalidValue(): void
	{
		Assert::exception(
			static function (): void {
				PositiveFloat::from(-0.1);
			},
			InvalidTypeException::class
		);
	}

	public function testValidValue(): void
	{
		Assert::same(0.1, PositiveFloat::from(0.1)->getValue());

		Assert::same(0.1, NumberHelpers::getFloatOrNull(PositiveFloat::from(0.1)));

		Assert::null(NumberHelpers::getFloatOrNull(PositiveFloat::fromOrNull(null)));
	}

}

(new PositiveFloatTest())->run();
