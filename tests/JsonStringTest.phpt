<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\JsonString;
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
			json_encode(['hello', '123', 456]),
		];

		foreach ($validValues as $value) {
			$jsonString = JsonString::encode($value);
			Assert::type(JsonString::class, $jsonString);

			Assert::equal(
				$value,
				$jsonString->getDecodedValue()
			);
		}
	}

}

(new JsonStringTest())->run();
