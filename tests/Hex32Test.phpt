<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class Hex32Test extends TestCase
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
					Hex32::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValue = 'ed9c1bede86c497fbb2f782324d394e1';

		$hex32 = Hex32::from($validValue);
		Assert::type(Hex32::class, $hex32);
		Assert::equal($validValue, $hex32->getValue());
	}

}

(new Hex32Test())->run();
