<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\UrlType;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class UrlTypeTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{

		$validValues = [
			'https://www.vyzva21dni.cz/sq-podekovani-2018/?utm_source=seznam&utm_medium=cpc&utm_campaign=Sklik-[sch] - Cviky%2C Cviceni&utm_content=Stehna&email=xxx@seeznam.cz',
		];

		foreach ($validValues as $validValue) {
			$url = UrlType::from($validValue);
			Assert::type(UrlType::class, $url);
		}
	}

}

(new UrlTypeTest())->run();