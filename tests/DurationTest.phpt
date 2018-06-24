<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/bootstrap.php';

final class DurationTest extends TestCase
{

	public function testCreate(): void
	{
		Duration::from([
			'value' => 1,
			'unit' => TimeUnit::HOURS,
		]);

		Duration::extract([
			'duration' => [
				'value' => -10,
				'unit' => TimeUnit::DAYS,
			],
		], 'duration');

		Duration::fromDateTimeModify('1 weeks');

		Duration::fromDateTimeModify('-10 months');
	}

	public function testGetUnit(): void
	{
		$duration = Duration::from([
			'value' => 1,
			'unit' => TimeUnit::YEARS,
		]);

		Assert::type(Duration::class, $duration);
		Assert::type(TimeUnit::class, $duration->getUnit());
	}

	public function testGetValue(): void
	{
		$duration = Duration::from([
			'value' => 1,
			'unit' => TimeUnit::DAYS,
		]);

		Assert::type(Duration::class, $duration);
		Assert::type('int', $duration->getValue());
		Assert::equal(1, $duration->getValue());
	}

	public function testGetDateTimeModify(Duration $duration, string $expectedDateTimeModify): void
	{
		Assert::equal($expectedDateTimeModify, $duration->getDateTimeModify());
	}

	/**
	 * @param mixed[] $expectedArray
	 */
	public function testToArray(Duration $duration, array $expectedArray): void
	{
		Assert::equal($expectedArray, $duration->toArray());
	}

	public function testSerialize(): void
	{
		$duration = Duration::fromDateTimeModify('1 weeks');
		Assert::type(Duration::class, Duration::from($duration->toArray()));
		Assert::type(Duration::class, Duration::extract(['duration' => $duration->toArray()], 'duration'));
	}

	/**
	 * @return mixed[]
	 */
	public function testGetDateTimeModifyData(): array
	{
		return [
			[Duration::fromDateTimeModify('-5 hours'), '-5 hours',],
			[Duration::fromDateTimeModify('-1 days'), '-1 days',],
			[Duration::fromDateTimeModify('-55 weeks'), '-55 weeks',],
			[Duration::fromDateTimeModify('-12 months'), '-12 months',],
			[Duration::fromDateTimeModify('-1 years'), '-1 years',],

			[Duration::fromDateTimeModify('5 hours'), '5 hours',],
			[Duration::fromDateTimeModify('1 days'), '1 days',],
			[Duration::fromDateTimeModify('55 weeks'), '55 weeks',],
			[Duration::fromDateTimeModify('12 months'), '12 months',],
			[Duration::fromDateTimeModify('1 years'), '1 years',],

			[Duration::fromDateTimeModify('+5 hours'), '5 hours',],
			[Duration::fromDateTimeModify('+1 days'), '1 days',],
			[Duration::fromDateTimeModify('+55 weeks'), '55 weeks',],
			[Duration::fromDateTimeModify('+12 months'), '12 months',],
			[Duration::fromDateTimeModify('+1 years'), '1 years',],
		];
	}

	/**
	 * @return mixed[]
	 */
	public function testToArrayData(): array
	{
		return [
			[Duration::fromDateTimeModify('-1 years'), ['value' => -1, 'unit' => TimeUnit::YEARS]],
			[Duration::fromDateTimeModify('2 months'), ['value' => 2, 'unit' => TimeUnit::MONTHS]],
			[Duration::fromDateTimeModify('+8 weeks'), ['value' => 8, 'unit' => TimeUnit::WEEKS]],
		];
	}

}

(new DurationTest())->run();
