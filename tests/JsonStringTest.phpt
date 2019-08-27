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

	public function testValid(): void
	{
		$json = JsonString::encode([1, 2, 3]);
		Assert::type('string', $json->getValue());

		Assert::equal($json, JsonString::from($json));

		$json = JsonString::from([]);
		Assert::equal('[]', $json->getValue());
		Assert::equal([], $json->getDecodedValue());

		$json = JsonString::from(123);
		Assert::equal('123', $json->getValue());
		Assert::equal(123, $json->getDecodedValue());

		$json = JsonString::from(['hello', '123', 456]);
		Assert::equal('[
    "hello",
    "123",
    456
]', $json->getValue());
		Assert::equal(['hello', '123', 456], $json->getDecodedValue());

		$json = JsonString::from(['test' => new \stdClass()]);
		Assert::equal('{
    "test": {}
}', $json->getValue());
		Assert::equal(['test' => []], $json->getDecodedValue());
	}

	public function testInvalid(): void
	{
		Assert::throws(
			static function (): void {
				JsonString::from(new \stdClass());
			},
			InvalidTypeException::class,
			'Expected types [string, array], got object (stdClass)'
		);

		Assert::throws(
			static function (): void {
				JsonString::from('{"test": "test"');
			},
			InvalidTypeException::class,
			'Invalid JSON string'
		);

		Assert::throws(
			static function (): void {
				JsonString::from('=');
			},
			InvalidTypeException::class,
			'Invalid JSON string'
		);
	}

}

(new JsonStringTest())->run();
