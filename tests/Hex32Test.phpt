<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class Hex32Test extends TestCase
{

	public function test1(): void
	{
		$invalidValues = [
			'ed9c1bede86c497fbb2f782324d394e1/cz-detail-962282-green-coffee-forte-6000-60tablet.html',
			'ed9c1bede86c497fbb2f782324d394e', // too short
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

	public function test2(): void
	{
		$guid = Guid::from('d7c8539e-089e-11e8-b161-2edbc134be21');
		Assert::type(Guid::class, $guid);

		$hex32 = Hex32::fromGuid($guid);
		Assert::type(Hex32::class, $hex32);
		Assert::equal('d7c8539e089e11e8b1612edbc134be21', $hex32->getValue());
	}

}

(new Hex32Test())->run();
