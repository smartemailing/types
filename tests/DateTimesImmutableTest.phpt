<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class DateTimesImmutableTest extends TestCase
{

	private const TEST_DATE_TIME = '2018-06-22 12:34:56';

	use ObjectMixinTrait;

	/**
	 * @param mixed $input
	 * @dataProvider defaultTestGenerator
	 */
	public function testValidDateTime($input): void
	{
		$date = DateTimesImmutable::from($input);
		Assert::type(\DateTimeImmutable::class, $date);
		Assert::same(self::TEST_DATE_TIME, DateTimeFormatter::format($date));
	}

	public function defaultTestGenerator(): array
	{
		return [
			[self::TEST_DATE_TIME],
			[\DateTime::createFromFormat(DateTimeFormat::DATETIME, self::TEST_DATE_TIME)],
			[\DateTimeImmutable::createFromFormat(DateTimeFormat::DATETIME, self::TEST_DATE_TIME)],
		];
	}

}

(new DateTimesImmutableTest())->run();
