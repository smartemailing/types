<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class HexColorTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$invalidValues = [
			'fff',
			'00668',
			'#00668',
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					HexColor::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			'#FFFFFF',
			'#FFF',
		];

		foreach ($validValues as $validValue) {
			$hexColor = HexColor::from($validValue);
			Assert::type(HexColor::class, $hexColor);
			Assert::equal($validValue, $hexColor->getValue());
		}

		$hexColor = HexColor::from('#fff');
		Assert::type(HexColor::class, $hexColor);
		Assert::equal('#FFF', $hexColor->getValue());
	}

}

(new HexColorTest())->run();
