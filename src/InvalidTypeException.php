<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

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
		$type = \gettype($value);

		if (\in_array($type, ['double', 'real'], true)) {
			$type = 'float';
		}

		$description = '';

		if (\is_scalar($value)) {
			$description = ' (' . (string) $value . ')';
		} elseif (\is_object($value)) {
			$description = ' (' . \get_class($value) . ')';
		}

		return new static(
			'Expected '
			. $expected
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

}
