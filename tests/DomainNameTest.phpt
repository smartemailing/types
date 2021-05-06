<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class DomainNameTest extends TestCase
{

	public function test1(): void
	{
		$invalidValues = [
			'abcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjk.test.cz',
			'abcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjk' .
			'abcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjk' .
			'abcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjk' .
			'abcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefghjkabcdefg.cz',
			'ýžřčšě.cz',
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					DomainName::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			'_spf.domena.test',
			'_jabber._tcp.gmail.com',
			'seznam.cz',
			'test.co.uk',
		];

		foreach ($validValues as $validValue) {
			$domain = DomainName::from($validValue);
			Assert::type(DomainName::class, $domain);
		}
	}

}

(new DomainNameTest())->run();
