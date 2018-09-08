<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class ZipCodeTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$invalidValues = [
			'dssdssdsd',
			'd7c8539e-089e-11e8-b161-2edbc134be21-12',
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					ZipCode::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			'39174',
		];

		foreach ($validValues as $validValue) {
			$zip = ZipCode::from($validValue);
			Assert::type(ZipCode::class, $zip);
			Assert::equal($validValue, $zip->getValue());
		}
	}

}

(new ZipCodeTest())->run();
