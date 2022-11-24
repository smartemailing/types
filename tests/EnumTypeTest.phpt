<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

enum Foo: string {

	case A = 'a';

}

final class EnumTypeTest extends TestCase
{

	public function test1(): void
	{
		Assert::exception(
			static function (): void {
				EnumType::extract(
					Foo::class,
					[],
					'enum'
				);
			},
			InvalidTypeException::class
		);

		Assert::null(
			EnumType::extractOrNull(
				Foo::class,
				[],
				'enum'
			)
		);

		Assert::exception(
			static function (): void {
				EnumType::extract(
					Foo::class,
					[
						'enum' => 1,
					],
					'enum'
				);
			},
			InvalidTypeException::class
		);

		Assert::exception(
			static function (): void {
				EnumType::extractOrNull(
					Foo::class,
					[
						'enum' => 1,
					],
					'enum'
				);
			},
			InvalidTypeException::class
		);

		Assert::exception(
			static function (): void {
				EnumType::extract(
					Foo::class,
					[
						'enum' => 'A',
					],
					'enum'
				);
			},
			InvalidTypeException::class
		);

		Assert::exception(
			static function (): void {
				EnumType::extractOrNull(
					Foo::class,
					[
						'enum' => 'A',
					],
					'enum'
				);
			},
			InvalidTypeException::class
		);

		Assert::same(
			Foo::A,
			EnumType::extract(
				Foo::class,
				[
					'enum' => 'a',
				],
				'enum'
			)
		);

		Assert::null(
			EnumType::extractOrNull(
				Foo::class,
				[
					'enum' => null,
				],
				'enum'
			)
		);

		Assert::exception(
			static function (): void {
				EnumType::extract(
					Foo::class,
					[
						'enum' => null,
					],
					'enum'
				);
			},
			InvalidTypeException::class
		);
	}

}

(new EnumTypeTest())->run();
