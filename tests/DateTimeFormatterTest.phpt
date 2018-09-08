<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class DateTimeFormatterTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		Assert::null(DateTimeFormatter::formatOrNull(null));
		Assert::equal(
			'2000-01-01 00:00:00',
			DateTimeFormatter::formatOrNull(
				new \DateTimeImmutable('2000-01-01 00:00:00')
			)
		);
	}

}

(new DateTimeFormatterTest())->run();
