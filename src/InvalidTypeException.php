<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Helpers\StringHelpers;

class InvalidTypeException extends \RuntimeException
{

	final public function __construct(
		string $message = '',
		int $code = 0,
		?\Throwable $previous = null
	)
	{
		parent::__construct($message, $code, $previous);
	}

	public static function typeError(
		string $expected,
		mixed $value
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
	 * @param array<string> $expected
	 */
	public static function typesError(
		array $expected,
		mixed $value
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

	public function wrap(
		string $key
	): self {
		$message = 'Problem at key '
			. $key
			. ': '
			. $this->getMessage();

		return new static($message, $this->code, $this);
	}

	private static function getType(
		mixed $value
	): string
	{
		$type = \gettype($value);

		if (\in_array($type, ['double', 'real'], true)) {
			$type = 'float';
		}

		return $type;
	}

	private static function getDescription(
		mixed $value
	): string
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
