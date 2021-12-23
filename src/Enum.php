<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use ReflectionClass;
use ReflectionClassConstant;

abstract class Enum
{

	/**
	 * @var mixed
	 */
	private $value;

	/**
	 * @var array<static> indexed by enum and value
	 */
	private static $instances = [];

	/**
	 * @var array<string, mixed>
	 */
	private static $availableValues = [];

	/**
	 * @param mixed $value
	 */
	final private function __construct(
		$value
	)
	{
		static::checkValue($value);
		$this->value = $value;
	}

	/**
	 * @param mixed $value
	 * @return static
	 */
	final public static function get(
		$value
	): self
	{
		$index = \sprintf('%s::%s', static::class, self::getValueIndex($value));

		if (!isset(self::$instances[$index])) {
			self::$instances[$index] = new static($value);
		}

		return self::$instances[$index];
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	public function equals(
		self $that
	): bool
	{
		$this->checkSameEnum($that);

		return $this === $that;
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	public function equalsValue(
		$value
	): bool
	{
		return $this->getValue() === $value;
	}

	/**
	 * @param mixed $value
	 * @throws \Exception
	 */
	public static function checkValue(
		$value
	): void
	{
		if (!\is_subclass_of(static::class, self::class)) {
			throw new \Exception(\sprintf(
				'"%s" is not a subclass of "%s"',
				static::class,
				self::class
			));
		}

		if (!static::isValidValue($value)) {
			$availableValues = static::getAvailableValues();

			throw new InvalidTypeException(
				\sprintf(
					'[%s] is not a valid value for %s, accepted values: %s',
					\gettype($value),
					static::class,
					\implode(', ', $availableValues)
				)
			);
		}
	}

	/**
	 * @return array<mixed>
	 */
	public static function getAvailableValues(): array
	{
		$index = static::class;

		if (!isset(self::$availableValues[$index])) {
			$availableValues = self::getEnumConstants();
			static::checkAvailableValues($availableValues);
			self::$availableValues[$index] = $availableValues;
		}

		return self::$availableValues[$index];
	}

	/**
	 * @return array<static>
	 */
	public static function getAvailableEnums(): array
	{
		$values = static::getAvailableValues();
		$out = [];

		foreach ($values as $value) {
			$out[$value] = static::get($value);
		}

		return $out;
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	public static function isValidValue(
		$value
	): bool
	{
		return \in_array($value, self::getAvailableValues(), true);
	}

	protected function checkSameEnum(
		self $that
	): void
	{
		if (\get_class($that) !== static::class) {
			throw new InvalidTypeException(\sprintf('Operation supported only for enum of same class: %s given, %s expected', \get_class($that), static::class));
		}
	}

	/**
	 * @param array<mixed> $availableValues
	 */
	protected static function checkAvailableValues(
		array $availableValues
	): void
	{
		$index = [];

		foreach ($availableValues as $value) {
			self::checkType($value);
			$key = self::getValueIndex($value);

			if (isset($index[$key])) {
				throw new InvalidTypeException(
					\sprintf(
						'Value %s [%s] is specified in %s\'s available values multiple times',
						$value,
						\gettype($value),
						static::class
					)
				);
			}

			$index[$key] = true;
		}
	}

	/**
	 * @param mixed $value
	 */
	private static function checkType(
		$value
	): void
	{
		if (\is_scalar($value) || $value === null) {
			return;
		}

			$valueType = \gettype($value);
			$printableValue = $value;

		if (\is_object($value)) {
			$valueType = \get_class($value);
			$printableValue = \get_class($value);
		}

		if (\is_array($value)) {
			$valueType = '';
		}

			throw new InvalidTypeException(
				\sprintf('%s expected, %s [%s] given', 'int|string|float|bool|null', $printableValue, $valueType)
			);
	}

	/**
	 * @param \ReflectionClass<static> $classReflection
	 * @return array<int, \ReflectionClassConstant>
	 */
	private static function getDeclaredConstants(
		ReflectionClass $classReflection
	): array
	{
		$constants = $classReflection->getReflectionConstants();
		$className = $classReflection->getName();

		return \array_filter(
			$constants,
			static function (ReflectionClassConstant $constant) use ($className): bool {
				return $constant->getDeclaringClass()->getName() === $className;
			}
		);
	}

	/**
	 * @param mixed $value
	 * @return string
	 */
	private static function getValueIndex(
		$value
	): string
	{
		$type = \gettype($value);

		return $value . \sprintf('[%s]', $type);
	}

	/**
	 * @return array<string, mixed>
	 */
	private static function getEnumConstants(): array
	{
		$classReflection = new ReflectionClass(static::class);
		$declaredConstants = self::getDeclaredConstants($classReflection);
		$declaredPublicConstants = \array_filter(
			$declaredConstants,
			static function (ReflectionClassConstant $constant): bool {
				return $constant->isPublic();
			}
		);

		$out = [];

		foreach ($declaredPublicConstants as $publicConstant) {
			\assert($publicConstant instanceof \ReflectionClassConstant);

			$out[$publicConstant->getName()] = $publicConstant->getValue();
		}

		return $out;
	}

}
