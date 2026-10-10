<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Helpers\StringHelpers;

class InvalidTypeException extends \RuntimeException // phpcs:ignore
{

	/**
	 * @var array<mixed>|null
	 */
	private ?array $acceptedValues;

	private ?string $key = null;

	/**
	 * @param string|null $publicMessage message safe to show to API clients (no class names or PHP types), defaults to $message
	 * @param array<mixed>|null $acceptedValues
	 */
	final public function __construct(
		string $message = '',
		int $code = 0,
		?\Throwable $previous = null,
		private ?string $publicMessage = null,
		private mixed $invalidValue = null,
		?array $acceptedValues = null
	)
	{
		parent::__construct($message, $code, $previous);

		$this->acceptedValues = $acceptedValues !== null
			? \array_values($acceptedValues)
			: null;
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
			. $description,
			0,
			null,
			self::isClassName($expected)
				? self::getPublicInvalidValueMessage($value)
				: self::getPublicExpectedMessage($expected, $value),
			$value
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
		$publicExpected = \array_filter(
			$expected,
			static fn (string $expectedType): bool => !self::isClassName($expectedType)
		);

		return new static(
			'Expected types '
			. '[' . \implode(', ', $expected) . ']'
			. ', got '
			. $type
			. $description,
			0,
			null,
			$publicExpected === []
				? self::getPublicInvalidValueMessage($value)
				: self::getPublicExpectedMessage(\implode(' or ', $publicExpected), $value),
			$value
		);
	}

	public static function missingKey(
		string $key
	): self {
		$exception = new static('Missing key: ' . $key);
		$exception->key = $key;

		return $exception;
	}

	public static function cannotBeEmptyError(
		string $key
	): self {
		$exception = new static('Array at key ' . $key . ' must not be empty.');
		$exception->key = $key;

		return $exception;
	}

	public function wrap(
		string $key
	): self {
		$prefix = 'Problem at key '
			. $key
			. ': ';

		$exception = new static(
			$prefix . $this->getMessage(),
			$this->code,
			$this,
			$prefix . $this->getPublicMessage(),
			$this->invalidValue,
			$this->acceptedValues
		);
		$exception->key = $this->key === null
			? $key
			: $key . '.' . $this->key;

		return $exception;
	}

	/**
	 * Message without internal details (class names, PHP types), suitable for public API responses.
	 */
	public function getPublicMessage(): string
	{
		return $this->publicMessage ?? $this->getMessage();
	}

	/**
	 * Path of keys where the error occurred, outer key first (e.g. "progress.committed_row_id").
	 */
	public function getKey(): ?string
	{
		return $this->key;
	}

	public function getInvalidValue(): mixed
	{
		return $this->invalidValue;
	}

	/**
	 * @return array<mixed>|null
	 */
	public function getAcceptedValues(): ?array
	{
		return $this->acceptedValues;
	}

	private static function getPublicExpectedMessage(
		string $expected,
		mixed $value
	): string
	{
		$publicValue = self::getPublicValue($value);

		return 'Expected ' . $expected . ', got ' . ($publicValue ?? \gettype($value));
	}

	private static function getPublicInvalidValueMessage(
		mixed $value
	): string
	{
		$publicValue = self::getPublicValue($value);

		return $publicValue === null
			? 'Invalid value'
			: 'Invalid value ' . $publicValue;
	}

	/**
	 * Printable scalar or null value, null for arrays and objects.
	 */
	private static function getPublicValue(
		mixed $value
	): ?string
	{
		return match (true) {
			\is_string($value) => '"' . StringHelpers::sanitize($value) . '"',
			\is_int($value), \is_float($value) => (string) $value,
			\is_bool($value) => $value ? 'true' : 'false',
			$value === null => 'null',
			default => null,
		};
	}

	private static function isClassName(
		string $expected
	): bool
	{
		return \str_contains($expected, '\\')
			|| \class_exists($expected, false)
			|| \interface_exists($expected, false);
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
			$description = ' (' . $value::class . ')';
		}

		return $description;
	}

}
