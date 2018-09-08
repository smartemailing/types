<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class DomainTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$invalidValues = [
			'sfhwiupokpkpkpppokpokhfwifhsfhwiupokpkpksfhwiupokpkpkpppokpokhfwifhiwefhiwfehufw' .
			'iuefhiueznamsfhwiupokpkpkpppokpokhfwifhiwefhiwfehufwiuefhiueznamsfhwiupokpkpkppp' .
			'okpokhfwifhiwefhiwfehufwiuefhiueznamsfhwiupokpkpkpppokpokhfwifhiwefhiwfehufwiuef' .
			'hiueznampppokpokhfwifhiwefhiwfehufwiuefhiueznamiwefhiwfehufwiuefhiueznamsfhwiupo' .
			'kpkpkpppokpokhfwifhiwefhiwfehufwiuefhiueznamsfhwiupokpkpkpppokpokhfwifhiwefhiwfe' .
			'hufwiuefhiueznamsfhwiupokpkpkpppokpokhfwifhiwefhiwfehufwiuefhiiuojojoojoeznam.cz',
			'ýžřčšě.cz',
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					Domain::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			'seznam.cz',
			'test.co.uk',
		];

		foreach ($validValues as $validValue) {
			$domain = Domain::from($validValue);
			Assert::type(Domain::class, $domain);
		}

		$domain = Domain::from('test.seznam.cz');
		Assert::equal('seznam.cz', $domain->getSecondLevelDomain()->getValue());

		$domain = Domain::from('test.seznam.co.uk');
		Assert::equal('seznam.co.uk', $domain->getSecondLevelDomain()->getValue());
	}

}

(new DomainTest())->run();
