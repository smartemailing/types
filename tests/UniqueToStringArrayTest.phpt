<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\Helpers\ArrayHelpers;
use SmartEmailing\Types\Helpers\UniqueToStringArray;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class UniqueToStringArrayTest extends TestCase
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
			[
				Emailaddress::from('test@smartemailing.cz'),
				Emailaddress::from('test2@smartemailing.cz'),
				IpAddress::from('8.8.8.8'),
			],
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					UniqueToStringArray::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [

			[
				Emailaddress::from('test@smartemailing.cz'),
				Emailaddress::from('test2@smartemailing.cz'),
			],
			[
				IpAddress::from('8.8.8.8'),
				IpAddress::from('8.8.4.4'),
			],
		];

		foreach ($validValues as $validValue) {
			$intArray = UniqueToStringArray::from($validValue);
			Assert::type(UniqueToStringArray::class, $intArray);
		}

		$ip1 = IpAddress::from('8.8.4.4');
		$append = UniqueToStringArray::from([$ip1]);
		Assert::equal([$ip1], $append->getValues());

		$ip2 = IpAddress::from('8.8.4.5');
		Assert::true($append->add($ip2));
		Assert::false($append->add($ip2));
		Assert::equal([$ip1, $ip2], $append->getValues());

		$append->remove(IpAddress::from('100.8.4.5'));
		Assert::equal([$ip1, $ip2], $append->getValues());

		$append->remove($ip1);
		Assert::equal([$ip2], $append->getValues());

		$empty = UniqueToStringArray::extractOrEmpty(
			[],
			'not_existing'
		);

		$deep = [
			'a' => $empty,
		];

		$empty2 = UniqueToStringArray::extractOrEmpty($deep, 'a');

		Assert::same($empty, $empty2);

		Assert::type(UniqueToStringArray::class, $empty);
		Assert::count(0, $empty);

		$data = [
			'data' => $empty,
		];
		$derived = UniqueToStringArray::extract(
			$data,
			'data'
		);
		Assert::type(UniqueToStringArray::class, $derived);

		$containsTest = UniqueToStringArray::from(
			[
				IpAddress::from('8.8.8.9'),
			]
		);
		Assert::true($containsTest->contains(IpAddress::from('8.8.8.9')));
		Assert::false($containsTest->contains(IpAddress::from('8.8.8.10')));

		$containsTest->add(IpAddress::from('8.8.8.10'));
		Assert::true($containsTest->contains(IpAddress::from('8.8.8.10')));

		$containsTest->remove(IpAddress::from('8.8.8.9'));
		Assert::false($containsTest->contains(IpAddress::from('8.8.8.9')));

		$deductable = UniqueToStringArray::from(
			[
				IpAddress::from('8.8.8.8'),
				IpAddress::from('8.8.8.9'),
			]
		);

		$toBeDeducted = UniqueToStringArray::from(
			[
				IpAddress::from('8.8.8.9'),
				IpAddress::from('8.8.8.10'),
			]
		);

		$result = $deductable->deduct($toBeDeducted);

		Assert::equal(
			[
				IpAddress::from('8.8.8.8'),
			],
			$result->getValues()
		);

		foreach ($result as $item) {
			Assert::type(IpAddress::class, $item);
		}

		$result->remove(IpAddress::from('8.8.8.8'));

		Assert::true($result->isEmpty());
	}

	public function testMerge(): void
	{
		$a = UniqueToStringArray::from(
			[
				IpAddress::from('8.8.8.8'),
				IpAddress::from('8.8.8.9'),
			]
		);

		$b = UniqueToStringArray::from(
			[
				IpAddress::from('8.8.8.8'),
				IpAddress::from('8.8.8.10'),
			]
		);

		$c = $b->merge($a);

		Assert::equal(3, \count($c->getValues()));
	}

	public function testIntersect(): void
	{
		$arr1 = UniqueToStringArray::from(
			[
				Emailaddress::from('a@b.com'),
			]
		);
		UniqueToStringArray::union(
			[
				$arr1,
			]
		);

		///

		$arr1 = UniqueToStringArray::from(
			[
				Emailaddress::from('a@b.com'),
				Emailaddress::from('b@b.com'),
				Emailaddress::from('c@b.com'),
				Emailaddress::from('d@b.com'),
			]
		);

		$arr2 = UniqueToStringArray::from(
			[
				Emailaddress::from('b@b.com'),
				Emailaddress::from('c@b.com'),
				Emailaddress::from('d@b.com'),
				Emailaddress::from('e@b.com'),
			]
		);

		$result = UniqueToStringArray::intersect(
			[
				$arr1,
				$arr2,
			]
		);

		$collection = ArrayHelpers::stringExtractableCollectionToArray(
			$result->toArray()
		);
		Assert::equal(
			[
				'b@b.com',
				'c@b.com',
				'd@b.com',
			],
			$collection
		);

		///

		$result = UniqueToStringArray::intersect(
			[
				UniqueToStringArray::from([]),
				UniqueToStringArray::from([]),
			]
		);

		Assert::equal(
			[],
			$result->toArray()
		);

		///
		$arr1 = UniqueToStringArray::from(
			[
				Emailaddress::from('a@b.com'),
			]
		);

		$arr2 = UniqueToStringArray::from(
			[
				Emailaddress::from('b@b.com'),
			]
		);

		$result = UniqueToStringArray::intersect(
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
		$arr1 = UniqueToStringArray::from(
			[
				Emailaddress::from('a@b.com'),
				Emailaddress::from('b@b.com'),
				Emailaddress::from('c@b.com'),
				Emailaddress::from('d@b.com'),
			]
		);

		$arr2 = UniqueToStringArray::from(
			[
				Emailaddress::from('c@b.com'),
				Emailaddress::from('d@b.com'),
				Emailaddress::from('e@b.com'),
			]
		);

		$result = UniqueToStringArray::union(
			[
				$arr1,
				$arr2,
			]
		);

		$collection = ArrayHelpers::stringExtractableCollectionToArray(
			$result->toArray()
		);
		Assert::equal(
			[
				'a@b.com',
				'b@b.com',
				'c@b.com',
				'd@b.com',
				'e@b.com',
			],
			$collection
		);

		///

		$result = UniqueToStringArray::union(
			[
				UniqueToStringArray::from([]),
				UniqueToStringArray::from([]),
			]
		);

		Assert::equal(
			[],
			$result->toArray()
		);
		///
	}

}

(new UniqueToStringArrayTest())->run();
