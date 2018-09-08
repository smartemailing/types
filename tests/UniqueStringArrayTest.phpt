<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class UniqueStringArrayTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$invalidValues = [
			[
				1,
				2,
				new \stdClass(),
			],
			[
				1,
				2,
				[],
			],
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					UniqueStringArray::from($invalidValue);
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
			$intArray = UniqueStringArray::from($validValue);
			Assert::type(UniqueStringArray::class, $intArray);
		}

		$append = UniqueStringArray::from([1]);
		Assert::equal(['1'], $append->getValues());

		$append->add('2');
		Assert::equal(['1', '2'], $append->getValues());

		$append->remove('12345');
		Assert::equal(['1', '2'], $append->getValues());

		$append->remove('1');
		Assert::equal(['2'], $append->getValues());

		$empty = UniqueStringArray::extractOrEmpty(
			[],
			'not_existing'
		);

		Assert::true($empty->isEmpty());

		Assert::type(UniqueStringArray::class, $empty);
		Assert::count(0, $empty);

		$data = [
			'data' => $empty,
		];
		$derived = UniqueStringArray::extract(
			$data,
			'data'
		);
		Assert::type(UniqueStringArray::class, $derived);

		$containsTest = UniqueStringArray::from(
			[
				'xxx',
			]
		);
		Assert::true($containsTest->contains('xxx'));
		Assert::false($containsTest->contains('yyy'));

		Assert::true($containsTest->add('yyy'));
		Assert::false($containsTest->add('yyy'));
		Assert::true($containsTest->contains('yyy'));

		$containsTest->remove('xxx');
		Assert::false($containsTest->contains('xxx'));

		$deductable = UniqueStringArray::from(
			[
				'a',
				'b',
			]
		);

		$toBeDeducted = UniqueStringArray::from(
			[
				'b',
				'c',
			]
		);

		$result = $deductable->deduct($toBeDeducted);

		Assert::equal(
			[
				'a',
			],
			$result->toArray()
		);

		$result->removeDuplicities();

		foreach ($result as $item) {
			Assert::type('string', $item);
		}
	}

}

(new UniqueStringArrayTest())->run();
