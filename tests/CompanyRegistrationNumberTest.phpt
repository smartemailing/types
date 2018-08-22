<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class CompanyRegistrationNumberTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$invalidValues = [
			'12345',
			'blabla',
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				function () use ($invalidValue): void {
					CompanyRegistrationNumber::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			'465 242 66', // SK
			'6 3 8 4 5 9 1 1', // FR
			'10675702', // GB
			'73270091', // CZ
		];

		foreach ($validValues as $validValue) {
			$crn = CompanyRegistrationNumber::from($validValue);
			Assert::type(CompanyRegistrationNumber::class, $crn);
		}
	}

}

(new CompanyRegistrationNumberTest())->run();
