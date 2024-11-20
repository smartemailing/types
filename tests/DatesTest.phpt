<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/bootstrap.php';

final class DatesTest extends TestCase
{

	public function testFrom(): void
	{
		Assert::noError(static fn () => Dates::from('2000-01-01'));

		Assert::noError(static fn () => Dates::from(new \DateTime('2000-01-01')));

		$d = Dates::from(new \DateTimeImmutable('2000-01-01'));
		Assert::equal('2000-01-01 00:00:00', DateTimeFormatter::format($d));

		Assert::throws(
			static function (): void {
				Dates::from('aaa');
			},
			InvalidTypeException::class
		);

		Assert::throws(
			static function (): void {
				Dates::from('2000-01-52');
			},
			InvalidTypeException::class
		);

		Assert::throws(
			static function (): void {
				Dates::from('2000-13-01');
			},
			InvalidTypeException::class
		);
	}

	public function testExtract(): void
	{
		$d = Dates::from('2010-01-01');
		$data = [
			'a' => 'xx',
			'b' => '2000-01-01',
			'c' => $d,
		];

		Assert::throws(
			static function () use ($data): void {
				Dates::extract($data, 'a');
			},
			InvalidTypeException::class
		);

		Assert::throws(
			static function () use ($data): void {
				Dates::extract($data, 'not-key');
			},
			InvalidTypeException::class
		);

		Assert::noError(static fn () => Dates::extract($data, 'b'));

		Assert::noError(static fn () => Dates::extract($data, 'c'));
	}

	public function testExtractOrNull(): void
	{
		$d = Dates::from('2010-01-01');
		$data = [
			'a' => 'xx',
			'b' => '2000-01-01',
			'c' => $d,
		];

		$d = Dates::extractOrNull($data, 'not-a-key');
		Assert::null($d);

		Assert::throws(
			static function () use ($data): void {
				Dates::extractOrNull($data, 'a');
			},
			InvalidTypeException::class
		);

		$d = Dates::extractOrNull($data, 'a', true);
		Assert::null($d);

		$d = Dates::extractOrNull($data, 'b');
		Assert::type(\DateTime::class, $d);

		$d = Dates::extractOrNull($data, 'b', true);
		Assert::type(\DateTime::class, $d);
	}

	public function testFromOrNull(): void
	{
		$date = Dates::fromOrNull('2000-01-01');
		Assert::type(\DateTime::class, $date);

		$date = Dates::fromOrNull(null);
		Assert::null($date);

		Assert::exception(static function (): void {
			DatesImmutable::fromOrNull('2000-01-01 00:00:00');
		}, InvalidTypeException::class);

		$date = Dates::fromOrNull('2000-01-01 00:00:00', true);
		Assert::null($date);
	}

}

(new DatesTest())->run();
