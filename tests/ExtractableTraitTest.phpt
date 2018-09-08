<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/bootstrap.php';

final class ExtractableTraitTest extends TestCase
{

	use ObjectMixinTrait;

	public function testExtract(): void
	{
		Assert::throws(
			static function (): void {
				Emailaddress::extract('aa', 'x');
			},
			InvalidTypeException::class
		);

		$emailaddress1 = Emailaddress::from('martin+1@smartemailing.cz');
		$data = [
			'x' => 'martin@smartemailing.cz',
			'y' => $emailaddress1,
			'z' => 'qq',
		];

		$emailaddress2 = Emailaddress::extract($data, 'x');
		Assert::type(Emailaddress::class, $emailaddress2);

		$emailaddress3 = Emailaddress::extract($data, 'y');
		Assert::same($emailaddress1, $emailaddress3);

		Assert::throws(
			static function () use ($data): void {
				Emailaddress::extract($data, 'z');
			},
			InvalidTypeException::class
		);
	}

	public function testExtractArrayOf(): void
	{
		$data = [
			'a' => [
				'martin+2@smartemailing.cz',
				'martin+3@smartemailing.cz',
			],
			'b' => [
				Emailaddress::from('martin+4@smartemailing.cz'),
				Emailaddress::from('martin+5@smartemailing.cz'),
				'martin+6@smartemailing.cz',
			],
			'c' => 'error here!',
			'd' => [
				'not-email',
			],
			'e' => [
				Emailaddress::from('martin+10@smartemailing.cz'),
				Emailaddress::from('martin+11@smartemailing.cz'),
			],
		];

		$arr = Emailaddress::extractArrayOf($data, 'a');
		Assert::equal(2, \count($arr));

		$arr = Emailaddress::extractArrayOf($data, 'b');
		Assert::equal(3, \count($arr));

		Assert::throws(
			static function () use ($data): void {
				Emailaddress::extractArrayOf($data, 'c');
			},
			InvalidTypeException::class
		);

		Assert::throws(
			static function () use ($data): void {
				Emailaddress::extractArrayOf($data, 'd');
			},
			InvalidTypeException::class
		);

		$arr = Emailaddress::extractArrayOfOrEmpty($data, 'a');
		Assert::equal(2, \count($arr));

		$arr = Emailaddress::extractArrayOfOrEmpty($data, 'not-existing-key');
		Assert::equal([], $arr);

		$arr = Emailaddress::extractArrayOf($data, 'e');
		Assert::equal(2, \count($arr));
	}

	public function testFromOrNull(): void
	{
		$e = Emailaddress::fromOrNull(null);
		Assert::null($e);

		$e = Emailaddress::fromOrNull('martin+6@smartemailing.cz');
		Assert::type(Emailaddress::class, $e);

		Assert::throws(
			static function (): void {
				Emailaddress::fromOrNull('qqqq');
			},
			InvalidTypeException::class
		);

		$e = Emailaddress::fromOrNull('qqqq', true);
		Assert::null($e);
	}

	public function testExtractOrNull(): void
	{
		Assert::throws(
			static function (): void {
				$data = 'a';
				Emailaddress::extractOrNull($data, 'a');
			},
			InvalidTypeException::class
		);

		$data = [
			'a' => '',
			'b' => 'qqq',
			'c' => 'martin+7@smartemailing.cz',
		];

		$e = Emailaddress::extractOrNull($data, 'not-key');
		Assert::null($e);

		$e = Emailaddress::extractOrNull($data, 'a');
		Assert::null($e);

		Assert::throws(
			static function () use ($data): void {
				Emailaddress::extractOrNull($data, 'b');
			},
			InvalidTypeException::class
		);

		$e = Emailaddress::extractOrNull($data, 'b', true);
		Assert::null($e);

		$e = Emailaddress::extractOrNull($data, 'c');
		Assert::type(Emailaddress::class, $e);

		$e2 = Emailaddress::from($e);
		Assert::same($e, $e2);
	}

}

(new ExtractableTraitTest())->run();
