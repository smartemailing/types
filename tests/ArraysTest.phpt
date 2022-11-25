<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;
use stdClass;

require_once __DIR__ . '/bootstrap.php';

final class ArraysTest extends TestCase
{

	public function testExtractArrayOrNull(): void
	{
		$data = ['data' => ['1', 1, true, 'etc', new \stdClass()]];
		Assert::type('array', Arrays::extractArrayOrNull($data, 'data'));

		$data = ['data' => null];
		Assert::null(Arrays::extractArrayOrNull($data, 'data'));

		$data = ['data' => 'a'];
		Assert::null(Arrays::extractArrayOrNull($data, 'data', true));

		Assert::throws(
			static function (): void {
				$data = ['data' => 'a'];
				Assert::null(Arrays::extractArrayOrNull($data, 'data'));
			},
			InvalidTypeException::class
		);
	}

	public function testExtractIntArray(): void
	{
		$data = ['data' => ['1', 1, '-999', 9]];
		Assert::type('array', Arrays::extractIntArray($data, 'data'));

		$data = ['data' => ['not-int']];
		Assert::exception(static function () use ($data): void {
			Arrays::extractIntArray($data, 'data');
		}, InvalidTypeException::class, 'Problem at key data: Expected int, got string (not-int)');
	}

	public function testExtractArray(): void
	{
		$data = ['data' => 'test'];
		Assert::exception(static function () use ($data): void {
			Arrays::extractArray($data, 'data');
		}, InvalidTypeException::class, 'Problem at key data: Expected array, got string (test)');
	}

	public function testGetArray(): void
	{
		$data = ['data' => ['1', 1, true, 'etc']];
		Assert::type('array', Arrays::getArray($data));
	}

	public function testGetArrayOrNull(): void
	{
		$data = null;
		Assert::null(Arrays::getArrayOrNull($data));

		$data = 'test';
		Assert::null(Arrays::getArrayOrNull($data, true));

		$data = 'test';
		Assert::exception(
			static function () use ($data): void {
				Arrays::getArrayOrNull($data);
			},
			InvalidTypeException::class,
			'Expected array, got string (test)'
		);
	}

	public function testExtractStringArray(): void
	{
		$data = ['data' => ['1', 1, true, 'etc']];
		Assert::type('array', Arrays::extractStringArray($data, 'data'));

		$data = ['data' => ['1', 1, true, 'etc', new \stdClass()]];
		Assert::exception(static function () use ($data): void {
			Arrays::extractStringArray($data, 'data');
		}, InvalidTypeException::class, 'Problem at key data: Expected string, got object (stdClass)');
	}

	public function testGetIntArray(): void
	{
		$intArray = Arrays::getIntArray(['1', 2, '-55', -99]);
		Assert::type('array', $intArray);

		foreach ($intArray as $item) {
			Assert::type('int', $item);
		}
	}

	public function testGetIntArrayOrNull(): void
	{
		$intArray = Arrays::getIntArrayOrNull(['1', 2, '-55', -99]);
		Assert::type('array', $intArray);

		$intArray = Arrays::getIntArrayOrNull(['x'], true);
		Assert::null($intArray);

		$intArray = Arrays::getIntArrayOrNull(null);
		Assert::null($intArray);

		Assert::throws(
			static function (): void {
				Arrays::getIntArrayOrNull(['a']);
			},
			InvalidTypeException::class
		);
	}

	public function testGetStringArray(): void
	{
		$stringArray = Arrays::getStringArray(['1', 2, '-55', -99]);
		Assert::type('array', $stringArray);

		foreach ($stringArray as $item) {
			Assert::type('string', $item);
		}
	}

	public function testGetStringArrayOrNull(): void
	{
		$stringArray = Arrays::getStringArrayOrNull(['1', 2, '-55', -99]);
		Assert::type('array', $stringArray);

		$stringArray = Arrays::getStringArrayOrNull([new stdClass()], true);
		Assert::null($stringArray);

		$intArray = Arrays::getStringArrayOrNull(null);
		Assert::null($intArray);

		Assert::throws(
			static function (): void {
				Arrays::getStringArrayOrNull([new stdClass()]);
			},
			InvalidTypeException::class
		);
	}

	public function testExtractIntArrayOrNull(): void
	{
		Assert::null(Arrays::extractIntArrayOrNull(['data' => null], 'data'));

		Assert::type('array', Arrays::extractIntArrayOrNull(['data' => ['1']], 'data'));
	}

	public function testExtractStringArrayOrNull(): void
	{
		Assert::null(Arrays::extractStringArrayOrNull(['data' => null], 'data'));

		Assert::null(Arrays::extractStringArrayOrNull(['data' => new stdClass()], 'data', true));

		Assert::type('array', Arrays::extractStringArrayOrNull(['data' => ['1']], 'data'));
	}

	public function testGetFloatArray(): void
	{
		Assert::same([1.0, 1.1, 2.5], Arrays::getFloatArray([1, '1.1', 2.5]));

		Assert::throws(
			static function (): void {
				Arrays::getFloatArray([1, 'failed', 2.5]);
			},
			InvalidTypeException::class,
			'Expected float, got string (failed)'
		);
	}

	public function testGetFloatArrayOrNull(): void
	{
		Assert::same([1.0, 1.1, 2.5], Arrays::getFloatArrayOrNull([1, '1.1', 2.5]));

		Assert::null(Arrays::getFloatArrayOrNull(null));

		Assert::null(Arrays::getFloatArrayOrNull([1, 'failed', 2.5], true));

		Assert::throws(
			static function (): void {
				Arrays::getFloatArrayOrNull([1, 'failed', 2.5]);
			},
			InvalidTypeException::class,
			'Expected float, got string (failed)'
		);
	}

	public function testExtractFloatArray(): void
	{
		Assert::same([1.0, 1.1, 2.5], Arrays::extractFloatArray(['floats' => [1, '1.1', 2.5]], 'floats'));

		Assert::throws(
			static function (): void {
				Arrays::extractFloatArray(['floats' => null], 'floats');
			},
			InvalidTypeException::class
		);

		Assert::throws(
			static function (): void {
				Arrays::extractFloatArray(['floats' => [1, 'failed', 2.5]], 'floats');
			},
			InvalidTypeException::class
		);
	}

	public function testExtractFloatArrayOrNull(): void
	{
		Assert::same([1.0, 1.1, 2.5], Arrays::extractFloatArrayOrNull(['floats' => [1, '1.1', 2.5]], 'floats'));

		Assert::null(Arrays::extractFloatArrayOrNull(['floats' => null], 'floats'));

		Assert::null(Arrays::extractFloatArrayOrNull(['floats' => [1, 'failed', 2.5]], 'floats', true));

		Assert::throws(
			static function (): void {
				Assert::null(Arrays::extractFloatArrayOrNull(['floats' => [1, 'failed', 2.5]], 'floats'));
			},
			InvalidTypeException::class
		);
	}

}

(new ArraysTest())->run();
