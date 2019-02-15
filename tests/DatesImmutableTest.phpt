<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/bootstrap.php';

final class DatesImmutableTest extends TestCase
{

	public function testFrom(): void
	{
		$d = DatesImmutable::from('2000-01-01');
		Assert::type(\DateTimeImmutable::class, $d);

		$d = DatesImmutable::from(new \DateTime('2000-01-01'));
		Assert::type(\DateTimeImmutable::class, $d);

		$d = DatesImmutable::from(new \DateTimeImmutable('2000-01-01'));
		Assert::equal('2000-01-01 00:00:00', DateTimeFormatter::format($d));

		Assert::throws(
			static function (): void {
				DatesImmutable::from('aaa');
			},
			InvalidTypeException::class
		);
	}

	public function testExtract(): void
	{
		$d = DatesImmutable::from('2010-01-01');
		$data = [
			'a' => 'xx',
			'b' => '2000-01-01',
			'c' => $d,
		];

		Assert::throws(
			static function () use ($data): void {
				DatesImmutable::extract($data, 'a');
			},
			InvalidTypeException::class
		);

		Assert::throws(
			static function () use ($data): void {
				DatesImmutable::extract($data, 'not-key');
			},
			InvalidTypeException::class
		);

		$d = DatesImmutable::extract($data, 'b');
		Assert::type(\DateTimeImmutable::class, $d);

		$d = DatesImmutable::extract($data, 'c');
		Assert::type(\DateTimeImmutable::class, $d);
	}

	public function testExtractOrNull(): void
	{
		$d = DatesImmutable::from('2010-01-01');
		$data = [
			'a' => 'xx',
			'b' => '2000-01-01',
			'c' => $d,
		];

		$d = DatesImmutable::extractOrNull($data, 'not-a-key');
		Assert::null($d);

		Assert::throws(
			static function () use ($data): void {
				DatesImmutable::extractOrNull($data, 'a');
			},
			InvalidTypeException::class
		);

		$d = DatesImmutable::extractOrNull($data, 'a', true);
		Assert::null($d);

		$d = DatesImmutable::extractOrNull($data, 'b');
		Assert::type(\DateTimeImmutable::class, $d);

		$d = DatesImmutable::extractOrNull($data, 'b', true);
		Assert::type(\DateTimeImmutable::class, $d);
	}

	public function testFromOrNull(): void
	{
		$date = DatesImmutable::fromOrNull('2000-01-01');
		Assert::type(\DateTimeImmutable::class, $date);

		$date = DatesImmutable::fromOrNull(null);
		Assert::null($date);

		Assert::exception(static function (): void {
			DatesImmutable::fromOrNull('2000-01-01 00:00:00');
		}, InvalidTypeException::class);

		$date = DatesImmutable::fromOrNull('2000-01-01 00:00:00', true);
		Assert::null($date);
	}

}

(new DatesImmutableTest())->run();
