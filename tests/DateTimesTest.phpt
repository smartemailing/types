<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class DateTimesTest extends TestCase
{

	public function testFrom(): void
	{
		$d = DateTimes::from('2000-01-01 00:00:00');

		$d2 = DateTimes::from($d);
		Assert::same($d, $d2);

		$d = DateTimes::from(new \DateTimeImmutable('2000-01-01 00:00:00'));
		Assert::equal('2000-01-01 00:00:00', DateTimeFormatter::format($d));

		Assert::throws(
			static function (): void {
				DateTimes::from('aaa');
			},
			InvalidTypeException::class
		);

		Assert::throws(
			static function (): void {
				DateTimes::from('2000-01-50 00:99:00.22');
			},
			InvalidTypeException::class
		);

		Assert::throws(
			static function (): void {
				DateTimes::from('2000-01-50 00:99:00');
			},
			InvalidTypeException::class
		);

		Assert::throws(
			static function (): void {
				DateTimes::from(
					[
						'date' => '1979-02-23 00:00:00.000000',
						'timezone' => 'Europe/Prague',
						'timezone_type' => 3,
					]
				);
			},
			InvalidTypeException::class
		);

		$d = DateTimes::from('2000-01-01 00:00:00.123456');
		Assert::equal('2000-01-01 00:00:00', DateTimeFormatter::format($d));

		$d = DateTimes::from('2020-01-01 08:35:21.000000');
		Assert::equal('2020-01-01 08:35:21', DateTimeFormatter::format($d));
	}

	public function testExtract(): void
	{
		$d = DateTimes::from('2010-01-01 00:00:00');
		$data = [
			'a' => 'xx',
			'b' => '2000-01-01 00:00:00',
			'c' => $d,
		];

		Assert::throws(
			static function () use ($data): void {
				DateTimes::extract($data, 'a');
			},
			InvalidTypeException::class
		);

		Assert::throws(
			static function () use ($data): void {
				DateTimes::extract($data, 'not-key');
			},
			InvalidTypeException::class
		);

		Assert::noError(static fn () => DateTimes::extract($data, 'b'));

		Assert::noError(static fn () => DateTimes::extract($data, 'c'));
	}

	public function testExtractDate(): void
	{
		$d = DateTimes::from('2010-01-01 10:00:00');
		$data = [
			'a' => 'xx',
			'b' => '2000-01-01',
			'c' => $d,
		];

		Assert::throws(
			static function () use ($data): void {
				DateTimes::extractDate($data, 'a');
			},
			InvalidTypeException::class
		);

		Assert::throws(
			static function () use ($data): void {
				DateTimes::extractDate($data, 'not-key');
			},
			InvalidTypeException::class
		);

		$d = DateTimes::extractDate($data, 'b');
		Assert::equal('2000-01-01 00:00:00', DateTimeFormatter::format($d));

		$d = DateTimes::extractDate($data, 'c');
		Assert::equal('2010-01-01 00:00:00', DateTimeFormatter::format($d));
	}

	public function testExtractDateOrNull(): void
	{
		$data = [
			'b' => '2000-01-01',
		];

		$d = DateTimes::extractDateOrNull($data, 'not-a-key');
		Assert::null($d);

		$d = DateTimes::extractDateOrNull($data, 'b');
		Assert::type(\DateTime::class, $d);
	}

	public function testExtractOrNull(): void
	{
		$d = DateTimes::from('2010-01-01 10:00:00');
		$data = [
			'a' => 'xx',
			'b' => '2000-01-01 00:00:00',
			'c' => $d,
		];

		$d = DateTimes::extractOrNull($data, 'not-a-key');
		Assert::null($d);

		Assert::throws(
			static function () use ($data): void {
				DateTimes::extractOrNull($data, 'a');
			},
			InvalidTypeException::class
		);

		$d = DateTimes::extractOrNull($data, 'a', true);
		Assert::null($d);

		$d = DateTimes::extractOrNull($data, 'b');
		Assert::type(\DateTime::class, $d);

		$d = DateTimes::extractOrNull($data, 'b', true);
		Assert::type(\DateTime::class, $d);
	}

}

(new DateTimesTest())->run();
