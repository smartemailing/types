<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Helpers;

use SmartEmailing\Types\UniqueStringArray;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/bootstrap.php';

final class ArrayHelpersTest extends TestCase
{

	public function testCollectionItemsToArray(): void
	{
		Assert::same(
			[
				['a', 'b', 'c'],
				['a', 'b', 'c'],
				['x', 'y', 'z'],
			],
			ArrayHelpers::collectionItemsToArray([
				UniqueStringArray::from(['a', 'b', 'c']),
				UniqueStringArray::from(['a', 'b', 'c']),
				UniqueStringArray::from(['x', 'y', 'z']),
			])
		);
	}

}

(new ArrayHelpersTest())->run();
