<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use ReflectionClass;
use ReflectionClassConstant;

abstract class Enum
{

	private mixed $value;

	/**
     * @var array<self> indexed by enum and value
     */
	private static array $instances = [];

	/**
     * @var array<string, mixed>
     */
	private static array $availableValues = [];

	private function __construct(
        mixed $value
    )
	{
		static::checkValue($value);
		$this->value = $value;
	}

    public function getValue(): mixed
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

    public function equalsValue(
        mixed $value
    ): bool
    {
        return $this->getValue() === $value;
    }

    public static function get(
        mixed $value
    ): static
    {
        $index = \sprintf('%s::%s', static::class, self::getValueIndex($value));

        if (!isset(self::$instances[$index])) {
            self::$instances[$index] = new static($value);
        }

        return self::$instances[$index];
    }

    public static function checkValue(
        mixed $value
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

            throw new InvalidTypeException(\sprintf(
                '%s [%s] is not a valid value for %s, accepted values: %s',
                $value,
                \get_debug_type($value),
                static::class,
                \implode(', ', $availableValues)
            ));
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

    public static function isValidValue(
        mixed $value
    ): bool
    {
        return \in_array($value, self::getAvailableValues(), true);
    }

    protected function checkSameEnum(
        self $that
    ): void
    {
        if ($this::class !== $that::class) {
            throw new InvalidTypeException(\sprintf('Operation supported only for enum of same class: %s given, %s expected', $that::class, $this::class));
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
//            Type::checkType($value, 'int|string|float|bool|null');
            $key = self::getValueIndex($value);

            if (isset($index[$key])) {
                throw new InvalidTypeException(
                    \sprintf(
                        'Value %s [%s] is specified in %s\'s available values multiple times',
                        $value,
                        \get_debug_type($value),
                        static::class
                    )
                );
            }

            $index[$key] = true;
        }
    }

	/**
	 * @return array<\ReflectionClassConstant>
	 */
	private static function getDeclaredConstants(
        ReflectionClass $classReflection
    ): array
	{
		$constants = $classReflection->getReflectionConstants();
		$className = $classReflection->getName();

		return \array_filter(
			$constants,
			static fn (ReflectionClassConstant $constant): bool => $constant->getDeclaringClass()->getName() === $className
		);
	}

	private static function getValueIndex(
        mixed $value
    ): string
	{
		$type = \get_debug_type($value);

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
			static fn (ReflectionClassConstant $constant): bool => $constant->isPublic()
		);

		$out = [];

		foreach ($declaredPublicConstants as $publicConstant) {
            \assert($publicConstant instanceof \ReflectionClassConstant);

			$out[$publicConstant->getName()] = $publicConstant->getValue();
		}

		return $out;
	}

}
