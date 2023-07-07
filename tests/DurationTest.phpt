<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;
use stdClass;

require_once __DIR__ . '/bootstrap.php';

final class DurationTest extends TestCase
{

	public function testException(): void
	{
		Assert::throws(
			static function (): void {
				Duration::fromDateTimeModify('test');
			},
			InvalidTypeException::class
		);

		Assert::throws(
			static function (): void {
				Duration::from([
                    'unit' => 'week',
                    'value' => 0,
				]);
			},
			InvalidTypeException::class
		);

		Assert::throws(
			static function (): void {
				Duration::from('xxx');
			},
			InvalidTypeException::class
		);

		Assert::throws(
			static function (): void {
				Duration::extract(['duration' => 1], 'duration');
			},
			InvalidTypeException::class,
			'Problem at key duration: Duration: 1  is not in valid duration format.'
		);

		Assert::throws(
			static function (): void {
				Duration::extract(['duration' => []], 'duration');
			},
			InvalidTypeException::class,
			'Problem at key duration: Missing key: value'
		);

		Assert::throws(
			static function (): void {
				Duration::extract(['duration' => new stdClass()], 'duration');
			},
			InvalidTypeException::class,
			'Problem at key duration: Expected types [string, array], got object (stdClass)'
		);
	}

	public function testCreate(): void
	{
		Duration::from([
            'unit' => TimeUnit::HOURS,
            'value' => 1,
		]);

		Duration::extract([
			'duration' => [
                'unit' => TimeUnit::DAYS,
                'value' => -10,
			],
		], 'duration');

		Duration::from('1 weeks');

		Duration::fromDateTimeModify('-10 months');

		Duration::extract(['duration' => '1 days'], 'duration');
	}

	public function testGetUnit(): void
	{
		$duration = Duration::from([
            'unit' => TimeUnit::YEARS,
            'value' => 1,
		]);

		Assert::type(Duration::class, $duration);
		Assert::type(TimeUnit::class, $duration->getUnit());
	}

	public function testGetValue(): void
	{
		$duration = Duration::from([
            'unit' => TimeUnit::DAYS,
            'value' => 1,
		]);

		Assert::type(Duration::class, $duration);
		Assert::type('int', $duration->getValue());
		Assert::equal(1, $duration->getValue());
	}

	public function testLengthInSeconds(): void
	{
		$duration = Duration::from([
            'unit' => TimeUnit::HOURS,
            'value' => 3,
		]);
		Assert::type(Duration::class, $duration);
		Assert::equal(10800, $duration->getLengthInSeconds());

		$duration = Duration::from([
            'unit' => TimeUnit::MINUTES,
            'value' => 10,
		]);
		Assert::type(Duration::class, $duration);
		Assert::equal(600, $duration->getLengthInSeconds());
	}

	public function testGetDateTimeModify(): void
	{
		foreach ($this->getTestDateTimeModifyData() as $data) {
			[$duration, $expectedDateTimeModify] = $data;

			Assert::equal($expectedDateTimeModify, $duration->getDateTimeModify());
		}
	}

	public function testToArray(): void
	{
		foreach ($this->getTestToArrayData() as $data) {
			[$duration, $expectedArray] = $data;

			Assert::equal($expectedArray, $duration->toArray());
		}
	}

	public function testSerialize(): void
	{
		$duration = Duration::fromDateTimeModify('1 weeks');

		Assert::type(Duration::class, Duration::from($duration->toArray()));
		Assert::type(Duration::class, Duration::extract(['duration' => $duration->toArray()], 'duration'));

		Assert::type(Duration::class, Duration::from((string) $duration));
	}

	/**
	 * @return array<array{
	 *     0: \SmartEmailing\Types\Duration,
	 *     1: string
	 * }>
	 */
	private function getTestDateTimeModifyData(): array
	{
		return [
			[Duration::fromDateTimeModify('-5 hours'), '-5 hours'],
			[Duration::fromDateTimeModify('-1 days'), '-1 days'],
			[Duration::fromDateTimeModify('-55 weeks'), '-55 weeks'],
			[Duration::fromDateTimeModify('-12 months'), '-12 months'],
			[Duration::fromDateTimeModify('-1 years'), '-1 years'],

			[Duration::fromDateTimeModify('5 hours'), '5 hours'],
			[Duration::fromDateTimeModify('1 days'), '1 days'],
			[Duration::fromDateTimeModify('55 weeks'), '55 weeks'],
			[Duration::fromDateTimeModify('12 months'), '12 months'],
			[Duration::fromDateTimeModify('1 years'), '1 years'],

			[Duration::fromDateTimeModify('+5 hours'), '5 hours'],
			[Duration::fromDateTimeModify('+1 days'), '1 days'],
			[Duration::fromDateTimeModify('+55 weeks'), '55 weeks'],
			[Duration::fromDateTimeModify('+12 months'), '12 months'],
			[Duration::fromDateTimeModify('+1 years'), '1 years'],
		];
	}

	/**
	 * @return array<array{
	 *     0: \SmartEmailing\Types\Duration,
	 *     1: array{
	 *         value: int,
	 *         unit: string
	 *     }
	 * }>
	 */
	private function getTestToArrayData(): array
	{
		return [
			[Duration::fromDateTimeModify('-1 years'), ['value' => -1, 'unit' => TimeUnit::YEARS]],
			[Duration::fromDateTimeModify('2 months'), ['value' => 2, 'unit' => TimeUnit::MONTHS]],
			[Duration::fromDateTimeModify('+8 weeks'), ['value' => 8, 'unit' => TimeUnit::WEEKS]],
		];
	}

}

(new DurationTest())->run();
