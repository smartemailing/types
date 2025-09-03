<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class HexColorAlphaTest extends TestCase
{

	public function test1(): void
	{
		$invalidValues = [
			'fff',
			'00668',
			'#00668',
			'#ff',
			'#zzzzzz',
			'skakalpes',
			'#ffffffffff'
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					HexColorAlpha::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			'#FFFFFF',
			'#FFF',
			'#FFFF',
			'#00FF00FF',
			'#000F',
		];

		foreach ($validValues as $validValue) {
			$hexColor = HexColorAlpha::from($validValue);
		}

		$hexColor = HexColorAlpha::from('#fff');
		Assert::equal('#FFFF', $hexColor->getValue());
	}

}

(new HexColorAlphaTest())->run();
