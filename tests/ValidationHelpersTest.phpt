<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Helpers\ValidationHelpers;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class ValidationHelpersTest extends TestCase
{

	public function testIsScalarLeavesArray(): void
	{
		Assert::true(ValidationHelpers::isScalarLeavesArray([]));
		Assert::true(ValidationHelpers::isScalarLeavesArray(['a', 1, false, true, null]));

		$input = [
			[
				'a',
			],
			[
				1,
			],
			[
				'b',
				[
					true,
					[
						null,
					],
					[],
				],
			],
		];

		Assert::true(ValidationHelpers::isScalarLeavesArray($input));

		Assert::false(ValidationHelpers::isScalarLeavesArray([new \StdClass()]));
		Assert::false(ValidationHelpers::isScalarLeavesArray([\tmpfile()]));
	}

}

(new ValidationHelpersTest())->run();
