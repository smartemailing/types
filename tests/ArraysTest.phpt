<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/bootstrap.php';

final class ArraysTest extends TestCase
{

	public function testExtractArrayOrNull(): void
	{
		$data = ['data' => ['1', 1, true, 'etc', new \stdClass()]];
		Assert::type('array', Arrays::extractArrayOrNull($data, 'data'));

		$data = ['data' => null];
		Assert::null(Arrays::extractArrayOrNull($data, 'data'));
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

	public function testGetStringArray(): void
	{
		$stringArray = Arrays::getStringArray(['1', 2, '-55', -99]);
		Assert::type('array', $stringArray);

		foreach ($stringArray as $item) {
			Assert::type('string', $item);
		}
	}

	public function testExtractIntArrayOrNull(): void
	{
		Assert::null(Arrays::extractIntArrayOrNull(['data' => null], 'data'));

		Assert::type('array', Arrays::extractIntArrayOrNull(['data' => ['1']], 'data'));
	}

	public function testExtractStringArrayOrNull(): void
	{
		Assert::null(Arrays::extractStringArrayOrNull(['data' => null], 'data'));

		Assert::type('array', Arrays::extractStringArrayOrNull(['data' => ['1']], 'data'));
	}

}

(new ArraysTest())->run();
