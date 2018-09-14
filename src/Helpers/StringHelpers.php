<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Helpers;

use Nette\Utils\Strings;

abstract class StringHelpers
{

	final public static function removeUtf8Mb4(
		string $value
	): string {
		return (string) \preg_replace(
			'/[\x{10000}-\x{10FFFF}]/u',
			"\xEF\xBF\xBD",
			$value
		);
	}

	final public static function sanitize(
		string $string
	): string {
		$string = Strings::fixEncoding($string);
		$string = self::removeUtf8Mb4($string);
		$string = Strings::trim($string);
		$string = self::normalizeLineEndings($string);
		return $string;
	}

	final public static function removeWhitespace(
		string $value
	): string {
		// removed whitespace
		$value = (string) \preg_replace(
			'/\s+/',
			'',
			$value
		);
		// removed unbreakable whitespace
		return (string) \preg_replace(
			'~\x{00a0}~',
			'',
			$value
		);
	}

	final public static function normalizeWhitespace(
		string $value
	): string {
		return (string) \preg_replace(
			'/\s+/',
			' ',
			$value
		);
	}

	final public static function normalizeLineEndings(
		string $value
	): string {
		return \strtr(
			$value,
			[
				"\r\n" => "\n",
				"\r" => "\n",
			]
		);
	}

}
