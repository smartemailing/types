<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Helpers;

use Nette\Utils\Strings;

abstract class StringHelpers
{

	final public static function sanitize(
		string $string
	): string {
		$string = Strings::fixEncoding($string);
		$string = self::removeUtf8Mb4($string);
		$string = Strings::trim($string);
		$string = self::normalizeLineEndings($string);

		return $string;
	}

	final public static function sanitizeOrNull(
		?string $string
	): ?string {
		if ($string === null) {
			return null;
		}

		return self::sanitize($string);
	}

	final public static function removeUtf8Mb4(
		string $value
	): string {
		return (string) \preg_replace(
			'/[\x{10000}-\x{10FFFF}]/u',
			"\xEF\xBF\xBD",
			$value
		);
	}

	final public static function removeWhitespace(
		string $value
	): string {
		$replaceTable = [
			\chr(0x9) => '',
			\chr(0xA) => '',
			\chr(0xB) => '',
			\chr(0xC) => '',
			\chr(0xD) => '',
			\chr(0x20) => '',
			\chr(0x85) => '',
			\chr(0xA0) => '',
			\chr(0x1680) => '',
			\chr(0x2000) => '',
			\chr(0x2001) => '',
			\chr(0x2002) => '',
			\chr(0x2003) => '',
			\chr(0x2004) => '',
			\chr(0x2005) => '',
			\chr(0x2006) => '',
			\chr(0x2007) => '',
			\chr(0x2008) => '',
			\chr(0x2009) => '',
			\chr(0x200A) => '',
			\chr(0x2028) => '',
			\chr(0x2029) => '',
			\chr(0x202F) => '',
			\chr(0x205F) => '',
			\chr(0x3000) => '',
			\chr(0xAD) => '',
			\chr(0xF0) => '',
			\chr(0xC2AD) => '',
			\chr(0xCA) => '',
			\chr(0xC2) => '',
		];

		return \strtr(
			$value,
			$replaceTable
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
