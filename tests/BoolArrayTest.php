<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/bootstrap.php';

final class BoolArrayTest extends TestCase
{

	public function testGet(): void
	{
		Assert::same(
			[true, false, true, false],
			BoolArray::from([1, 0, 'true', 'false'])
		);

		Assert::exception(
			static function (): void {
				BoolArray::from([1, 0, 'true', 'not false']);
			},
			InvalidTypeException::class
		);
	}

	public function testGetOrNull(): void
	{
		Assert::same(null, BoolArray::fromOrNull(null));

		Assert::same(null, BoolArray::fromOrNull(['not true'], true));

		Assert::same(
			[true, false, true, false],
			BoolArray::fromOrNull([1, 0, 'true', 'false'])
		);

		Assert::exception(
			static function (): void {
				BoolArray::fromOrNull([1, 0, 'true', 'not false']);
			},
			InvalidTypeException::class
		);
	}

	public function textExtract(): void
	{
		Assert::same(
			[true, false, true, false],
			BoolArray::extract(['a' => [1, 0, 'true', 'false']], 'a')
		);
	}

	public function textExtractOrNull(): void
	{
		Assert::null(BoolArray::extractOrNull([], 'a'));

		Assert::same(
			[true, false, true, false],
			BoolArray::extractOrNull(['a' => [1, 0, 'true', 'false']], 'a')
		);
	}

}

(new BoolArrayTest())->run();
