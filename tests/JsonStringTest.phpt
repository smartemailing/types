<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class JsonStringTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$validValues = [
			123,
			'[]',
			\json_encode(['hello', '123', 456]),
		];

		foreach ($validValues as $value) {
			$jsonString = JsonString::encode($value);
			Assert::type(JsonString::class, $jsonString);

			Assert::equal(
				$value,
				$jsonString->getDecodedValue()
			);
		}

		$j = JsonString::encode([1, 2, 3]);

		Assert::type('string', $j->getValue());
	}

	public function test2(): void
	{
		Assert::throws(
			static function (): void {
				JsonString::from([]);
			},
			InvalidTypeException::class
		);

		Assert::throws(
			static function (): void {
				JsonString::from('=');
			},
			InvalidTypeException::class
		);
	}

}

(new JsonStringTest())->run();
