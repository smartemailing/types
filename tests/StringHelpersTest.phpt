<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\Helpers\StringHelpers;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/bootstrap.php';

final class StringHelpersTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$string = 'a     b  ' . \PHP_EOL . 'c' . \PHP_EOL;

		Assert::equal('a b c ', StringHelpers::normalizeWhitespace($string));
	}

}

(new StringHelpersTest())->run();
