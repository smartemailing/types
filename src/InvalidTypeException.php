<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Helpers\StringHelpers;

class InvalidTypeException extends \RuntimeException
{

	public function wrap(
		string $key
	): self {
		$message = 'Problem at key '
			. $key
			. ': '
			. $this->getMessage();

		return new static($message);
	}

	/**
	 * @param string $expected
	 * @param mixed|mixed[] $value
	 * @return \SmartEmailing\Types\InvalidTypeException
	 */
	public static function typeError(
		string $expected,
		$value
	): self {
		$type = self::getType($value);
		$description = self::getDescription($value);

		return new static(
			'Expected '
			. $expected
			. ', got '
			. $type
			. $description
		);
	}

	/**
	 * @param string[] $expected
	 * @param mixed|mixed[] $value
	 * @return \SmartEmailing\Types\InvalidTypeException
	 */
	public static function typesError(
		array $expected,
		$value
	): self {
		$type = self::getType($value);
		$description = self::getDescription($value);

		return new static(
			'Expected types '
			. '[' . \implode(', ', $expected) . ']'
			. ', got '
			. $type
			. $description
		);
	}

	public static function missingKey(
		string $key
	): self {
		return new static('Missing key: ' . $key);
	}

	public static function cannotBeEmptyError(
		string $key
	): self {
		return new static('Array at key ' . $key . ' must not be empty.');
	}

	/**
	 * @param mixed $value
	 * @return string
	 */
	private static function getType($value): string
	{
		$type = \gettype($value);

		if (\in_array($type, ['double', 'real'], true)) {
			$type = 'float';
		}

		return $type;
	}

	/**
	 * @param mixed $value
	 * @return string
	 */
	private static function getDescription($value): string
	{
		$description = '';

		if (\is_scalar($value)) {
			$stringValue = (string) $value;
			$stringValue = StringHelpers::sanitize($stringValue);
			$description = ' (' . $stringValue . ')';
		} elseif (\is_object($value)) {
			$description = ' (' . \get_class($value) . ')';
		}

		return $description;
	}

}
