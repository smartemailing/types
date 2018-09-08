<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
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
			static function (): void {
				PrimitiveTypes::getInt('ščščř');
			},
			InvalidTypeException::class,
			'Expected int, got string (ščščř)'
		);
		Assert::throws(
			static function (): void {
				PrimitiveTypes::getInt([1, 2, 3]);
			},
			InvalidTypeException::class,
			'Expected int, got array'
		);

		Assert::equal(1, PrimitiveTypes::extractInt(['test' => 1], 'test'));
		Assert::equal(1, PrimitiveTypes::extractIntOrNull(['test' => 1], 'test'));
		Assert::equal(null, PrimitiveTypes::extractIntOrNull(['test' => 1], 'foo'));

		Assert::throws(
			static function (): void {
				PrimitiveTypes::extractInt(['test' => 1], 'foo');
			},
			InvalidTypeException::class,
			'Missing key: foo'
		);

		Assert::throws(
			static function (): void {
				PrimitiveTypes::extractInt(['test' => []], 'test');
			},
			InvalidTypeException::class
		);

		Assert::equal(10174, PrimitiveTypes::getInt('0010174'));

		Assert::equal(0, PrimitiveTypes::getInt('0'));
		Assert::equal(0, PrimitiveTypes::getInt('000'));
	}

	public function testFloat(): void
	{
		Assert::equal(1.0, PrimitiveTypes::getFloat(1.0));
		Assert::equal(333.3, PrimitiveTypes::getFloat('333.3'));
		Assert::equal(333.3, PrimitiveTypes::getFloat('00333.3'));
		Assert::throws(
			static function (): void {
				PrimitiveTypes::getFloat('ščščř');
			},
			InvalidTypeException::class,
			'Expected float, got string (ščščř)'
		);
		Assert::throws(
			static function (): void {
				PrimitiveTypes::getFloat([1, 2, 3]);
			},
			InvalidTypeException::class,
			'Expected float, got array'
		);

		Assert::equal(1.0, PrimitiveTypes::extractFloat(['test' => 1.0], 'test'));
		Assert::equal(1.0, PrimitiveTypes::extractFloatOrNull(['test' => 1.0], 'test'));
		Assert::equal(null, PrimitiveTypes::extractFloatOrNull(['test' => 1.0], 'foo'));

		Assert::throws(
			static function (): void {
				PrimitiveTypes::extractFloat(['test' => 1], 'foo');
			},
			InvalidTypeException::class,
			'Missing key: foo'
		);

		Assert::throws(
			static function (): void {
				PrimitiveTypes::extractFloat(['test' => 'ppppp'], 'test');
			},
			InvalidTypeException::class
		);
	}

	public function testString(): void
	{
		Assert::equal('1', PrimitiveTypes::getString(1.0));
		Assert::equal('333.3', PrimitiveTypes::getString('333.3'));
		Assert::throws(
			static function (): void {
				PrimitiveTypes::getString([1, 2, 3]);
			},
			InvalidTypeException::class,
			'Expected string, got array'
		);

		Assert::equal('aaa', PrimitiveTypes::extractString(['test' => 'aaa'], 'test'));
		Assert::equal('aaa', PrimitiveTypes::extractStringOrNull(['test' => 'aaa'], 'test'));
		Assert::equal(null, PrimitiveTypes::extractStringOrNull(['test' => 'aaa'], 'foo'));

		Assert::throws(
			static function (): void {
				PrimitiveTypes::extractString(['test' => 'aaa'], 'foo');
			},
			InvalidTypeException::class,
			'Missing key: foo'
		);

		Assert::throws(
			static function (): void {
				PrimitiveTypes::extractString(['test' => []], 'test');
			},
			InvalidTypeException::class
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
			static function (): void {
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
			static function (): void {
				PrimitiveTypes::getBool(null);
			},
			InvalidTypeException::class,
			'Expected bool, got NULL'
		);

		Assert::throws(
			static function (): void {
				PrimitiveTypes::getBool([1, 2, 3]);
			},
			InvalidTypeException::class,
			'Expected bool, got array'
		);

		$data = [
			'x' => true,
			'y' => 'aaaa',
		];

		Assert::throws(
			static function () use ($data): void {
				PrimitiveTypes::extractBool($data, 'y');
			},
			InvalidTypeException::class
		);

		$bool = PrimitiveTypes::extractBool($data, 'x');
		Assert::true($bool);

		$bool = PrimitiveTypes::extractBoolOrNull($data, 'x');
		Assert::true($bool);

		$null = PrimitiveTypes::extractBoolOrNull($data, 'not-exist');
		Assert::null($null);
	}

	public function testArray(): void
	{
		Assert::equal([1, 2, 3], PrimitiveTypes::getArray([1, 2, 3]));

		Assert::throws(
			static function (): void {
				PrimitiveTypes::getArray('aaa');
			},
			InvalidTypeException::class,
			'Expected array, got string (aaa)'
		);
	}

	public function testExtractArrayOrNull(): void
	{
		$data = [
			'null' => null,
			'non_empty_array' => [1, 2, 3],
			'not_an_array' => 'hello!',
		];

		Assert::null(PrimitiveTypes::extractArrayOrNull($data, 'test'));
		Assert::null(PrimitiveTypes::extractArrayOrNull($data, 'null'));
		Assert::same([1, 2, 3], PrimitiveTypes::extractArrayOrNull($data, 'non_empty_array'));
		Assert::exception(
			static function () use ($data): void {
				PrimitiveTypes::extractArrayOrNull($data, 'not_an_array');
			},
			InvalidTypeException::class
		);
	}

}

(new PrimitiveTypesTest())->run();
