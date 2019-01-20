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

		$string = '!\"#$%&\'() * +,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^ _`abcdefghijklmnopqrstuvwxyz{|}~';

		$result = StringHelpers::normalizeWhitespace($string);

		Assert::equal($string, $result);
	}

	public function testSanitizeOrNull(): void
	{
		$string = "čš \n\r\n a   ";

		Assert::equal("čš \n\n a", StringHelpers::sanitizeOrNull($string));
		Assert::equal(null, StringHelpers::sanitizeOrNull(null));
	}

	public function testRemoveWhitespace(): void
	{
		// contains soft hyphens
		$string = '+420 607 988 394' . \PHP_EOL;

		$noWhitespace = StringHelpers::removeWhitespace($string);

		Assert::equal(
			'+420607988394',
			$noWhitespace
		);
	}

}

(new StringHelpersTest())->run();
