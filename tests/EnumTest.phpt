<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\EnumExtractableTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

class SimpleEnum extends Enum
{

	use EnumExtractableTrait;

	public const TEST = 'test';

}

final class EnumTest extends TestCase
{

	public function testInvalidTypeException(): void
	{
		Assert::exception(
			static function (): void {
				SimpleEnum::get(new \stdClass());
			},
			InvalidTypeException::class,
			'stdClass [object] is not a valid value for SmartEmailing\Types\SimpleEnum, accepted values: test'
		);

		Assert::exception(
			static function (): void {
				SimpleEnum::extract(['test' => new \stdClass()], 'test');
			},
			InvalidTypeException::class,
			'Problem at key test: stdClass [object] is not a valid value for SmartEmailing\Types\SimpleEnum, accepted values: test'
		);

		Assert::exception(
			static function (): void {
				SimpleEnum::extract(['test' => [new \stdClass()]], 'test');
			},
			InvalidTypeException::class,
			'Problem at key test: [{}] [array] is not a valid value for SmartEmailing\Types\SimpleEnum, accepted values: test'
		);

		Assert::exception(
			static function (): void {
				SimpleEnum::extract(['test' => static function (): void {}], 'test');
			},
			InvalidTypeException::class,
			'Problem at key test: Closure [object] is not a valid value for SmartEmailing\Types\SimpleEnum, accepted values: test'
		);
	}

}

(new EnumTest())->run();
