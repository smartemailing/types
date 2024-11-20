<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class Base64StringTest extends TestCase
{

	public function test1(): void
	{
		$invalidValues = [
			'12345',
			\base64_encode('test') . 'x',
			\base64_encode('test') . '=',
			\base64_encode('test') . '==',
			\base64_encode('test') . '===',
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					Base64String::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			'1234',
			\base64_encode('test'),
		];

		foreach ($validValues as $base64) {
			Assert::noError(static fn () => Base64String::from($base64));
		}

		$b = Base64String::encode('hello');
		Assert::equal('hello', $b->getDecodedValue());

		Assert::true($b->equals(Base64String::encode('hello')));
		Assert::false($b->equals(Base64String::encode('1234')));
	}

}

(new Base64StringTest())->run();
