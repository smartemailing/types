<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Helpers;

use SmartEmailing\Types\InvalidTypeException;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

final class ExtractableHelpersTest extends TestCase
{

	public function testExtractValueVol2(): void
	{
		$value = ExtractableHelpers::extractValueVol2(
			[
				'a' => [
					'b' => [
						'c' => 'test',
					],
				],
			],
			['a', 'b', 'c']
		);

		Assert::same('test', $value);

		$value = ExtractableHelpers::extractValueVol2(
			[
				'a' => [
					'b' => [
						'c' => 'test',
					],
				],
			],
			['a', 'b']
		);

		Assert::same(['c' => 'test'], $value);

		Assert::exception(
			static function (): void {
				ExtractableHelpers::extractValueVol2(
					[
						'a' => [
							'b' => [
								'c' => 'test',
							],
						],
					],
					['a', 'c']
				);
			},
			InvalidTypeException::class,
			'Missing key: a -> c'
		);
	}

}

(new ExtractableHelpersTest())->run();
