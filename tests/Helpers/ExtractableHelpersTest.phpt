<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Helpers;

use ArrayObject;
use SmartEmailing\Types\InvalidTypeException;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';


final class ExtractableHelpersTest extends TestCase
{

	public function testExtractValueFromArray(): void
	{
		$array = ['a' => 'a', 1 => 1];
		Assert::same('a', ExtractableHelpers::extractValue($array, 'a'));

		Assert::same(1, ExtractableHelpers::extractValue($array, 1));

		Assert::exception(
			static fn () => ExtractableHelpers::extractValue($array, 'b'),
			InvalidTypeException::class,
			'Missing key: b'
		);

		Assert::exception(
			static fn () => ExtractableHelpers::extractValue($array, '2'),
			InvalidTypeException::class,
			'Missing key: 2'
		);
	}

	public function testExtractValueFromArrayAccess(): void
	{
		$arrayObject = new ArrayObject(['a' => 'a', 1 => 1]);

		Assert::same('a', ExtractableHelpers::extractValue($arrayObject, 'a'));

		Assert::same(1, ExtractableHelpers::extractValue($arrayObject, 1));

		Assert::exception(
			static fn () => ExtractableHelpers::extractValue($arrayObject, 'b'),
			InvalidTypeException::class,
			'Missing key: b'
		);

		Assert::exception(
			static fn () => ExtractableHelpers::extractValue($arrayObject, '2'),
			InvalidTypeException::class,
			'Missing key: 2'
		);
	}

}

(new ExtractableHelpersTest())->run();
