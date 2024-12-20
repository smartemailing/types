<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Strings;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class GuidTest extends TestCase
{

	public function test1(): void
	{
		$invalidValues = [
			'dssdssdsd',
			'd7c8539e-089e-11e8-b161-2edbc134be21-12',
			'x7c8539e-089e-11e8-b161-2edbc134be21',
			'7c8539e089e11e8b1612edbc134be21',
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					Guid::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			'd7c8539e-089e-11e8-b161-2edbc134be21',
			'd7c8539e-089E-11E8-B161-2edbc134be21',
		];

		foreach ($validValues as $validValue) {
			$guid = Guid::from($validValue);

			Assert::equal(
				Strings::lower($validValue),
				$guid->getValue()
			);
		}
	}

	public function test2(): void
	{
		$hex32 = Hex32::from('d7c8539e089e11e8b1612edbc134be21');

		$guid = Guid::fromHex32($hex32);
		Assert::equal('d7c8539e-089e-11e8-b161-2edbc134be21', $guid->getValue());
	}

}

(new GuidTest())->run();
