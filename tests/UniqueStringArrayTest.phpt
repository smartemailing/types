<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class UniqueStringArrayTest extends TestCase
{

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
			Assert::noError(static fn () => UniqueStringArray::from($validValue));
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
		Assert::count(0, $empty);

		$data = [
			'data' => $empty,
		];

		Assert::noError(static fn () => UniqueStringArray::extract($data, 'data'));

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
	}

}

(new UniqueStringArrayTest())->run();
