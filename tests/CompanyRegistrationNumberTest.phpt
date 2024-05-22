<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class CompanyRegistrationNumberTest extends TestCase
{

	public function test1(): void
	{
		$invalidValues = [
			'12345',
			'blabla',
			'CHEE-266911092', //CH
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					CompanyRegistrationNumber::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			'465 242 66', // SK
			'6 3 8 4 5 9 1 1', // FR
			'10675702', // GB
			'4718132070', // GB
			'73270091', // CZ
			'368990747', // PL
			'367090770', // PL
			'292 103 72', // CZ
			'05847940', // CZ
			'02948990', // CZ
			'38-4094176', // US
			'Y3899173C', // ES
			'CHE-266.911.092', //CH
			'12/345/67890', //DE
			'181/815/08155', //DE
			'133/8150/8159', //DE
			'34562345678', //HR
			'67845678934', //HR
			'32145678934', //HR
			'33127977', // NL
			'001632553B28', // NL
			'500271615', // PT
			'B82454', // LU
            '1234567T', // IE
            '1234567FA',// IE
            '2036426OA',// IE
            '996861833', // EL
		];

		foreach ($validValues as $validValue) {
			$crn = CompanyRegistrationNumber::from($validValue);
			Assert::type(CompanyRegistrationNumber::class, $crn);
		}

		$number = CompanyRegistrationNumber::from('73270091');
		Assert::equal('73270091', $number->getValue());
	}

}

(new CompanyRegistrationNumberTest())->run();
