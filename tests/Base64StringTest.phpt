<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\Base64String;
use SmartEmailing\Types\InvalidTypeException;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class Base64StringTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{

		$invalidValues = [
			'12345',
			base64_encode('test') . 'x',
			base64_encode('test') . '=',
			base64_encode('test') . '==',
			base64_encode('test') . '===',
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				function () use ($invalidValue) {
					Base64String::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			'1234',
			base64_encode('test'),
		];

		foreach ($validValues as $base64) {
			$phone = Base64String::from($base64);
			Assert::type(Base64String::class, $phone);
		}
	}

}

(new Base64StringTest())->run();