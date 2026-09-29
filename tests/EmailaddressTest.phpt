<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class EmailaddressTest extends TestCase
{

	public function test1(): void
	{
		$invalidValues = [
			\hex2bin('aaaaaa'),
			'12345',
			'test@seznam.teoiuoioiuoiuoiuuoiteuzt',
			'test@seznam',
			'test@' .
			'sfhwiupokpkpkpppokpokhfwifhsfhwiupokpkpksfhwiupokpkpkpppokpokhfwifhiwefhiwfehufw' .
			'iuefhiueznamsfhwiupokpkpkpppokpokhfwifhiwefhiwfehufwiuefhiueznamsfhwiupokpkpkppp' .
			'okpokhfwifhiwefhiwfehufwiuefhiueznamsfhwiupokpkpkpppokpokhfwifhiwefhiwfehufwiuef' .
			'hiueznampppokpokhfwifhiwefhiwfehufwiuefhiueznamiwefhiwfehufwiuefhiueznamsfhwiupo' .
			'kpkpkpppokpokhfwifhiwefhiwfehufwiuefhiueznamsfhwiupokpkpkpppokpokhfwifhiwefhiwfe' .
			'hufwiuefhiueznamsfhwiupokpkpkpppokpokhfwifhiwefhiwfehufwiuefhiiuojojoojoeznam.cz',
			'"h. iveta"@atlas.cz',
			'bce-se_n.16236.11.477_"h. xxx"-atlas.cz@se-acc-16236.se-bounce-0002.cz',
			// RFC 5321: local part over 64 octets
			\str_repeat('a', 65) . '@seznam.cz',
			// RFC 5321: whole address over 254 octets, domain labels themselves valid
			\str_repeat('a', 64) . '@' . \str_repeat('b', 62) . '.' . \str_repeat('c', 62) . '.' . \str_repeat('d', 61) . '.cz',
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					Emailaddress::from($invalidValue);
				},
				InvalidEmailaddressException::class,
				'Invalid emailaddress: ' . $invalidValue
			);
		}

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					Emailaddress::extract(['email' => $invalidValue], 'email');
				},
				InvalidEmailaddressException::class,
				'Problem at key email: Invalid emailaddress: ' . $invalidValue
			);
		}

		$validValues = [
			'íýžčíýžčýíčíýžč@seznam.cz',
			'608024038@post.cz',
			'-xyz-@seznam.cz',
			'martin@smartemailing.cz',
			'test-@seznam.cz',
			'realdruid@abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijk.com',
			// RFC 5321 boundaries: local part exactly 64 octets, whole address exactly 254 octets
			\str_repeat('a', 64) . '@seznam.cz',
			\str_repeat('a', 64) . '@' . \str_repeat('b', 62) . '.' . \str_repeat('c', 62) . '.' . \str_repeat('d', 60) . '.cz',
		];

		foreach ($validValues as $validValue) {
			Assert::noError(static fn () => Emailaddress::from($validValue));
		}

		$e = Emailaddress::from('martin@smartemailing.cz');
		Assert::equal('martin', $e->getLocalPart());
		Assert::equal('smartemailing.cz', $e->getDomain()->getValue());
		Assert::equal('smartemailing.cz', $e->getHostName()->getValue());
	}

}

(new EmailaddressTest())->run();
