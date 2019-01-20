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
		$replaceTable = [];

		foreach (InvisibleSpaceCharacterCodes::getCodes() as $charCode) {
			$replaceTable[\chr($charCode)] = '';
		}

		return \strtr(
			$value,
			$replaceTable
		);
	}

	final public static function normalizeWhitespace(
		string $value
	): string {
		$replaceTable = [];

		foreach (InvisibleSpaceCharacterCodes::getCodes() as $charCode) {
			$replaceTable[\chr($charCode)] = ' ';
		}

		$value = \strtr(
			$value,
			$replaceTable
		);

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
