<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class NonEmptyStringTest extends TestCase
{

	public function testValid(): void
	{
		$string = NonEmptyString::from('test');

		Assert::same('test', $string->getValue());
		Assert::same('test', (string) $string);

		$string = NonEmptyString::from(' test ');

		Assert::same('test', (string) $string);

		$string = NonEmptyString::from(" test \n");

		Assert::same('test', (string) $string);
	}

	public function testInvalid(): void
	{
		Assert::throws(
			static function (): void {
				NonEmptyString::from(' ');
			},
			InvalidTypeException::class,
			'Value must be non empty string.'
		);

		Assert::throws(
			static function (): void {
				NonEmptyString::extract(['data' => " \n"], 'data');
			},
			InvalidTypeException::class,
			'Problem at key data: Value must be non empty string.'
		);
	}

}

(new NonEmptyStringTest())->run();
