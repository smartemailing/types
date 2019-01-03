<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class DateTimesImmutableTest extends TestCase
{

	use ObjectMixinTrait;

	public function testFrom(): void
	{
		$d = DateTimesImmutable::from('2000-01-01 00:00:00');
		Assert::type(\DateTimeImmutable::class, $d);
	}

	public function testExtract(): void
	{
		$data = [
			'b' => '2000-01-01 00:00:00',
		];

		$d = DateTimesImmutable::extract($data, 'b');
		Assert::type(\DateTimeImmutable::class, $d);
	}

	public function testExtractDate(): void
	{
		$data = [
			'b' => '2000-01-01',
		];
		$d = DateTimesImmutable::extractDate($data, 'b');
		Assert::type(\DateTimeImmutable::class, $d);
	}

	public function testExtractDateOrNull(): void
	{
		$data = [
			'b' => '2000-01-01',
		];

		$d = DateTimesImmutable::extractDateOrNull($data, 'not-a-key');
		Assert::null($d);

		$d = DateTimesImmutable::extractDateOrNull($data, 'b');
		Assert::type(\DateTimeImmutable::class, $d);
	}

	public function testExtractOrNull(): void
	{
		$data = [
			'b' => '2000-01-01 00:00:00',
		];

		$d = DateTimesImmutable::extractOrNull($data, 'not-a-key');
		Assert::null($d);

		$d = DateTimesImmutable::extractOrNull($data, 'b');
		Assert::type(\DateTimeImmutable::class, $d);
	}

	public function testFromOrNull(): void
	{
		$date = DateTimesImmutable::fromOrNull('2000-01-01 00:00:00');
		Assert::type(\DateTimeImmutable::class, $date);

		$date = DateTimesImmutable::fromOrNull(null);
		Assert::null($date);

		Assert::exception(static function (): void {
			DateTimesImmutable::fromOrNull('2000-01-01');
		}, InvalidTypeException::class);

		$date = DateTimesImmutable::fromOrNull('2000-01-01', true);
		Assert::null($date);
	}

}

(new DateTimesImmutableTest())->run();
