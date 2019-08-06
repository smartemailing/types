<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class UniqueIntArrayTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$invalidValues = [
			[
				'a',
				'c',
				new \stdClass(),
			],
			[
				'b',
				'a',
				[],
			],
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					UniqueIntArray::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			[
				'1',
				'2',
				'3',
			],
			[
				1,
				2,
				3,
			],
		];

		foreach ($validValues as $validValue) {
			$intArray = UniqueIntArray::from($validValue);
			Assert::type(UniqueIntArray::class, $intArray);
		}

		$append = UniqueIntArray::from([1]);
		Assert::equal([1], $append->getValues());

		$append->add(2);
		Assert::equal([1, 2], $append->getValues());

		$append->remove(12345);
		Assert::equal([1, 2], $append->getValues());

		$append->remove(1);
		Assert::equal([2], $append->getValues());

		$empty = UniqueIntArray::extractOrEmpty(
			[],
			'not_existing'
		);

		Assert::type(UniqueIntArray::class, $empty);
		Assert::count(0, $empty);

		$data = [
			'data' => $empty,
		];
		$derived = UniqueIntArray::extract(
			$data,
			'data'
		);
		Assert::type(UniqueIntArray::class, $derived);

		$containsTest = UniqueIntArray::from(
			[
				123,
			]
		);
		Assert::true($containsTest->contains(123));
		Assert::false($containsTest->contains(321));

		Assert::true($containsTest->add(321));
		Assert::false($containsTest->add(321));
		Assert::true($containsTest->contains(321));

		$containsTest->remove(123);
		Assert::false($containsTest->contains(123));

		$deductable = UniqueIntArray::from(
			[
				1,
				2,
			]
		);

		$toBeDeducted = UniqueIntArray::from(
			[
				2,
				3,
			]
		);

		$result = $deductable->deduct($toBeDeducted);

		Assert::equal(
			[
				1,
			],
			$result->toArray()
		);

		foreach ($result as $item) {
			Assert::type('int', $item);
		}

		$arr = UniqueIntArray::from(
			[
				2,
				1,
			]
		);
		$arr->orderASC();
		Assert::equal(
			[
				1,
				2,
			],
			$arr->toArray()
		);
	}

	public function testIntersect(): void
	{
		$arr1 = UniqueIntArray::from(
			[
				0,
			]
		);

		UniqueIntArray::intersect(
			[
				$arr1,
			]
		);

		///

		$arr1 = UniqueIntArray::from(
			[
				0,
				1,
				2,
				3,
			]
		);

		$arr2 = UniqueIntArray::from(
			[
				2,
				3,
				4,
				5,
			]
		);

		$result = UniqueIntArray::intersect(
			[
				$arr1,
				$arr2,
			]
		);

		Assert::equal(
			[
				2,
				3,
			],
			$result->toArray()
		);

		///

		$result = UniqueIntArray::intersect(
			[
				UniqueIntArray::from([]),
				UniqueIntArray::from([]),
			]
		);

		Assert::equal(
			[],
			$result->toArray()
		);

		///
		$arr1 = UniqueIntArray::from(
			[
				0,
			]
		);

		$arr2 = UniqueIntArray::from(
			[
				1,
			]
		);

		$result = UniqueIntArray::intersect(
			[
				$arr1,
				$arr2,
			]
		);

		Assert::equal(
			[],
			$result->toArray()
		);
	}

	public function testUnion(): void
	{
		$arr1 = UniqueIntArray::from(
			[
				0,
				1,
				2,
				3,
			]
		);

		$arr2 = UniqueIntArray::from(
			[
				2,
				3,
				4,
				5,
			]
		);

		$result = UniqueIntArray::union(
			[
				$arr1,
				$arr2,
			]
		);

		Assert::equal(
			[
				0,
				1,
				2,
				3,
				4,
				5,
			],
			$result->toArray()
		);

		///

		$result = UniqueIntArray::union(
			[
				UniqueIntArray::from([]),
				UniqueIntArray::from([]),
			]
		);

		Assert::equal(
			[],
			$result->toArray()
		);

		///
		$arr1 = UniqueIntArray::from(
			[
				333,
			]
		);

		$arr2 = UniqueIntArray::from(
			[
				1,
			]
		);

		$result = UniqueIntArray::union(
			[
				$arr1,
				$arr2,
			]
		);

		Assert::equal(
			[
				333,
				1,
			],
			$result->toArray()
		);
	}

}

(new UniqueIntArrayTest())->run();
