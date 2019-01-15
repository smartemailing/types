<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class ScalarLeavesArrayTest extends TestCase
{

	public function testIsScalarLeavesArray(): void
	{
		$scalarArray = ScalarLeavesArray::from([]);
		Assert::type(ScalarLeavesArray::class, $scalarArray);

		Assert::equal([], $scalarArray->toArray());

		$input = [
			[
				'a',
			],
			[
				1,
			],
			[
				'b',
				[
					true,
					[
						null,
					],
					[],
				],
			],
		];

		$scalarArray = ScalarLeavesArray::from($input);
		Assert::type(ScalarLeavesArray::class, $scalarArray);
		Assert::equal($input, $scalarArray->toArray());

		Assert::throws(
			static function (): void {
				ScalarLeavesArray::from([new \StdClass()]);
			},
			InvalidTypeException::class
		);

		Assert::throws(
			static function (): void {
				ScalarLeavesArray::from([\tmpfile()]);
			},
			InvalidTypeException::class
		);

		$data = [
			'key' => $input,
		];

		$scalarArray = ScalarLeavesArray::extractOrEmpty($data, 'key');
		Assert::type(ScalarLeavesArray::class, $scalarArray);
		Assert::equal($input, $scalarArray->toArray());

		$scalarArray = ScalarLeavesArray::extractOrEmpty($data, 'not_existing');
		Assert::type(ScalarLeavesArray::class, $scalarArray);
		Assert::equal([], $scalarArray->toArray());
	}

}

(new ScalarLeavesArrayTest())->run();
