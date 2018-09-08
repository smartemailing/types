<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class EmailaddressTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$invalidValues = [
			'12345',
			'-testx@seznam.cz',
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
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				static function () use ($invalidValue): void {
					Emailaddress::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			'íýžčíýžčýíčíýžč@seznam.cz',
			'608024038@post.cz',
			'martin@smartemailing.cz',
			'test-@seznam.cz',
		];

		foreach ($validValues as $validValue) {
			$emailaddress = Emailaddress::from($validValue);
			Assert::type(Emailaddress::class, $emailaddress);
		}

		$e = Emailaddress::from('martin@smartemailing.cz');
		Assert::equal('martin', $e->getLocalPart());
		Assert::equal('smartemailing.cz', $e->getDomain()->getValue());
	}

}

(new EmailaddressTest())->run();
