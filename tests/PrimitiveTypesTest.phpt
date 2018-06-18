<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\InvalidTypeException;
use SmartEmailing\Types\PrimitiveTypes;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class PrimitiveTypesTest extends TestCase
{

	use ObjectMixinTrait;

	public function testInt(): void
	{
		Assert::equal(1, PrimitiveTypes::getInt(1));
		Assert::equal(333, PrimitiveTypes::getInt('333'));
		Assert::throws(
			function () {
				PrimitiveTypes::getInt('ščščř');
			},
			InvalidTypeException::class,
			'Expected int, got string (ščščř)'
		);
		Assert::throws(
			function () {
				PrimitiveTypes::getInt([1, 2, 3]);
			},
			InvalidTypeException::class,
			'Expected int, got array'
		);

		Assert::equal(1, PrimitiveTypes::extractInt(['test' => 1], 'test'));
		Assert::equal(null, PrimitiveTypes::extractIntOrNull(['test' => 1], 'foo'));

		Assert::throws(
			function () {
				PrimitiveTypes::extractInt(['test' => 1], 'foo');
			},
			InvalidTypeException::class,
			'Missing key: foo'
		);

		Assert::equal(10174, PrimitiveTypes::getInt('0010174'));

	}

	public function testFloat(): void
	{
		Assert::equal(1.0, PrimitiveTypes::getFloat(1.0));
		Assert::equal(333.3, PrimitiveTypes::getFloat('333.3'));
		Assert::equal(333.3, PrimitiveTypes::getFloat('00333.3'));
		Assert::throws(
			function () {
				PrimitiveTypes::getFloat('ščščř');
			},
			InvalidTypeException::class,
			'Expected float, got string (ščščř)'
		);
		Assert::throws(
			function () {
				PrimitiveTypes::getFloat([1, 2, 3]);
			},
			InvalidTypeException::class,
			'Expected float, got array'
		);

		Assert::equal(1.0, PrimitiveTypes::extractFloat(['test' => 1.0], 'test'));
		Assert::equal(null, PrimitiveTypes::extractFloatOrNull(['test' => 1.0], 'foo'));

		Assert::throws(
			function () {
				PrimitiveTypes::extractFloat(['test' => 1], 'foo');
			},
			InvalidTypeException::class,
			'Missing key: foo'
		);
	}

	public function testString(): void
	{
		Assert::equal('1', PrimitiveTypes::getString(1.0));
		Assert::equal('333.3', PrimitiveTypes::getString('333.3'));
		Assert::throws(
			function () {
				PrimitiveTypes::getString([1, 2, 3]);
			},
			InvalidTypeException::class,
			'Expected string, got array'
		);

		Assert::equal('aaa', PrimitiveTypes::extractString(['test' => 'aaa'], 'test'));
		Assert::equal(null, PrimitiveTypes::extractStringOrNull(['test' => 'aaa'], 'foo'));

		Assert::throws(
			function () {
				PrimitiveTypes::extractString(['test' => 'aaa'], 'foo');
			},
			InvalidTypeException::class,
			'Missing key: foo'
		);

		$array = [
			'aaa',
			'bbb',
			'ccc',
		];

		Assert::equal(
			$array,
			PrimitiveTypes::extractStringArray(['test' => $array], 'test')
		);

		Assert::throws(
			function () {
				PrimitiveTypes::extractStringArray(['test' => [[]]], 'test');
			},
			InvalidTypeException::class,
			'Problem at key test: Expected string, got array'
		);
	}

	public function testBool(): void
	{
		Assert::true(PrimitiveTypes::getBool(1));
		Assert::true(PrimitiveTypes::getBool(true));
		Assert::true(PrimitiveTypes::getBool('1'));

		Assert::false(PrimitiveTypes::getBool(0));
		Assert::false(PrimitiveTypes::getBool('0'));
		Assert::false(PrimitiveTypes::getBool(false));

		Assert::throws(
			function () {
				PrimitiveTypes::getBool(null);
			},
			InvalidTypeException::class,
			'Expected bool, got NULL'
		);

		Assert::throws(
			function () {
				PrimitiveTypes::getBool([1, 2, 3]);
			},
			InvalidTypeException::class,
			'Expected bool, got array'
		);
	}

	public function testArray(): void
	{
		Assert::equal([1, 2, 3], PrimitiveTypes::getArray([1, 2, 3]));

		Assert::throws(
			function () {
				PrimitiveTypes::getArray('aaa');
			},
			InvalidTypeException::class,
			'Expected array, got string (aaa)'
		);
	}

}

(new PrimitiveTypesTest())->run();
