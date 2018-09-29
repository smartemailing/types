<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class DateTimeRangeTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		Assert::throws(
			static function (): void {
				$data = [
					'to' => '2000-01-01 00:00:00',
					'from' => '2100-01-01 00:00:00',
				];
				DateTimeRange::from($data);
			},
			InvalidTypeException::class
		);

		$data = [
			'from' => '2100-01-01 00:00:00',
			'to' => '2100-01-02 00:00:00',
		];

		$dateTimeRange = DateTimeRange::from($data);
		Assert::type(DateTimeRange::class, $dateTimeRange);

		Assert::equal($data, $dateTimeRange->toArray());

		Assert::equal(
			3600 * 24,
			$dateTimeRange->getDurationInSeconds()
		);

		Assert::equal(
			'2100-01-01 00:00:00',
			DateTimeFormatter::format($dateTimeRange->getFrom())
		);

		Assert::equal(
			'2100-01-02 00:00:00',
			DateTimeFormatter::format($dateTimeRange->getTo())
		);

		Assert::true($dateTimeRange->contains(new \DateTimeImmutable('2100-01-01 12:00:00')));
		Assert::false($dateTimeRange->contains(new \DateTimeImmutable('2100-02-01 12:00:00')));
	}

}

(new DateTimeRangeTest())->run();
