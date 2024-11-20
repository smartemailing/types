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
		Assert::equal($input, $scalarArray->toArray());

		Assert::throws(
			static function (): void {
				ScalarLeavesArray::from([new \stdClass()]);
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
		Assert::equal($input, $scalarArray->toArray());

		$scalarArray = ScalarLeavesArray::extractOrEmpty($data, 'not_existing');
		Assert::equal([], $scalarArray->toArray());
	}

}

(new ScalarLeavesArrayTest())->run();
