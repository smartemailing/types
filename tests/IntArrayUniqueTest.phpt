<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class IntArrayUniqueTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$invalidValues = [
			[
				1,
				2,
				'a',
			],
			[
				1,
				2,
				new \stdClass(),
			],
			[
				1.0,
				2,
				3,
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

		Assert::throws(
			static function (): void {
				$data = [
					'arr' => [],
				];
				UniqueIntArray::extractNotEmpty($data, 'arr');
			},
			InvalidTypeException::class
		);

		$data = [
			'arr' => [
				1,
				2,
			],
		];
		$notEmpty = UniqueIntArray::extractNotEmpty($data, 'arr');

		Assert::equal([1, 2], $notEmpty->getValues());

		Assert::true($notEmpty->contains(1));
		Assert::false($notEmpty->contains(44));

		$data = [
			1,
			2,
			3,
			4,
			5,
		];

		$intArray = UniqueIntArray::from($data);

		$chunks = $intArray->split(2);
		Assert::count(3, $chunks);

		Assert::count(2, $chunks[0]->toArray());
		Assert::count(2, $chunks[1]->toArray());
		Assert::count(1, $chunks[2]->toArray());
	}

}

(new IntArrayUniqueTest())->run();
