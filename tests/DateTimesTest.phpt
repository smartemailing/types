<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class DateTimesTest extends TestCase
{

	use ObjectMixinTrait;

	public function testFrom(): void
	{
		$d = DateTimes::from('2000-01-01 00:00:00');
		Assert::type(\DateTime::class, $d);

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

		$d = DateTimes::from('2000-01-01 00:00:00.123456');
		Assert::equal('2000-01-01 00:00:00', DateTimeFormatter::format($d));
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

		$d = DateTimes::extract($data, 'b');
		Assert::type(\DateTime::class, $d);

		$d = DateTimes::extract($data, 'c');
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
