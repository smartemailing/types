<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class HexStringTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$invalidValues = [
			'ed9c1bede86c497fbb2f782324d394e1/cz-detail-962282-green-coffee-forte-6000-60tablet.html',
			'ed9c1bede86c497fbb2f782324d394e',  // too short
			'ed9c1bede86c497fbb2f782324d394e1a', // too long
			'gd9c1bede86c497fbb2f782324d394e1', // g letter
			'test@seznam',
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					Emailaddress::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			'ed9c1bede86c497fbb2f782324d394e1',
		];

		foreach ($validValues as $validValue) {
			$hexString = Hex32::from($validValue);
			Assert::type(Hex32::class, $hexString);
		}
	}

}

(new HexStringTest())->run();
