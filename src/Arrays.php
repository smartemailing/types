<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Helpers\ExtractableHelpers;

abstract class Arrays implements ExtractableTypeInterface
{

    /**
     * @return array<mixed>
     * @deprecated use Arrays::from
     */
    final public static function getArray(
		mixed $value
    ): array {
        return self::from($value);
    }

    /**
     * @return array<mixed>|null
     * @deprecated use Arrays::::fromOrNull
     */
    final public static function getArrayOrNull(
		mixed $value,
        bool $nullIfInvalid = false
    ): ?array {
        return self::fromOrNull($value, $nullIfInvalid);
    }

    /**
     * Preserves keys
     *
     * @param array<mixed> $data
     * @return array<mixed>
     * @throws \SmartEmailing\Types\InvalidTypeException
     * @deprecated use Arrays::extract
     */
    final public static function extractArray(
        array $data,
        string $key
    ): array
    {
        return self::extract($data, $key);
    }

    /**
     * Preserves keys
     *
     * @param array<mixed> $data
     * @return array<mixed>|null
     * @throws \SmartEmailing\Types\InvalidTypeException
     * @deprecated use Arrays::extractOrNull
     */
    final public static function extractArrayOrNull(
        array $data,
        string $key,
        bool $nullIfInvalid = false
    ): ?array {
        return self::extractOrNull($data, $key, $nullIfInvalid);
    }

    /**
     * @return array<int>
     * @deprecated use IntArray::from
     */
    final public static function getIntArray(
		mixed $value
    ): array {
        return IntArray::from($value);
    }

    /**
     * @return array<int>|null
     * @deprecated use IntArray::::fromOrNull
     */
    final public static function getIntArrayOrNull(
		mixed $value,
        bool $nullIfInvalid = false
    ): ?array {
        return IntArray::fromOrNull($value, $nullIfInvalid);
    }

    /**
     * @param array<mixed> $data
     * @return array<int>
     * @throws \SmartEmailing\Types\InvalidTypeException
     * @deprecated use IntArray::extract
     */
    final public static function extractIntArray(
        array $data,
        string $key
    ): array {
        return IntArray::extract($data, $key);
    }

    /**
     * @param array<mixed> $data
     * @return array<int>|null
     * @throws \SmartEmailing\Types\InvalidTypeException
     * @deprecated use IntArray::extractOrNull
     */
    final public static function extractIntArrayOrNull(
        array $data,
        string $key,
        bool $nullIfInvalid = false
    ): ?array {
        return IntArray::extractOrNull($data, $key, $nullIfInvalid);
    }

    /**
     * @return array<float>
     * @deprecated use FloatArray::from
     */
    final public static function getFloatArray(
		mixed $value
    ): array {
        return FloatArray::from($value);
    }

    /**
     * @return array<float>|null
     * @deprecated use FloatArray::::fromOrNull
     */
    final public static function getFloatArrayOrNull(
		mixed $value,
        bool $nullIfInvalid = false
    ): ?array {
        return FloatArray::fromOrNull($value, $nullIfInvalid);
    }

    /**
     * @param array<mixed> $data
     * @return array<float>
     * @throws \SmartEmailing\Types\InvalidTypeException
     * @deprecated use FloatArray::extract
     */
    final public static function extractFloatArray(
        array $data,
        string $key
    ): array {
        return FloatArray::extract($data, $key);
    }

    /**
     * @param array<mixed> $data
     * @return array<float>|null
     * @throws \SmartEmailing\Types\InvalidTypeException
     * @deprecated use FloatArray::extractOrNull
     */
    final public static function extractFloatArrayOrNull(
        array $data,
        string $key,
        bool $nullIfInvalid = false
    ): ?array {
        return FloatArray::extractOrNull($data, $key, $nullIfInvalid);
    }

    /**
     * @return array<string>
     * @deprecated use StringArray::from
     */
    final public static function getStringArray(
		mixed $value
    ): array {
        return StringArray::from($value);
    }

    /**
     * @return array<string>|null
     * @deprecated use StringArray::::fromOrNull
     */
    final public static function getStringArrayOrNull(
		mixed $value,
        bool $nullIfInvalid = false
    ): ?array {
        return StringArray::fromOrNull($value, $nullIfInvalid);
    }

    /**
     * @param array<mixed> $data
     * @return array<string>
     * @throws \SmartEmailing\Types\InvalidTypeException
     * @deprecated use StringArray::extract
     */
    final public static function extractStringArray(
        array $data,
        string $key
    ): array {
        return StringArray::extract($data, $key);
    }

    /**
     * @param array<mixed> $data
     * @return array<string>|null
     * @throws \SmartEmailing\Types\InvalidTypeException
     * @deprecated use StringArray::extractOrNull
     */
    final public static function extractStringArrayOrNull(
        array $data,
        string $key,
        bool $nullIfInvalid = false
    ): ?array {
        return StringArray::extractOrNull($data, $key, $nullIfInvalid);
    }

	/**
	 * @return array<mixed>
	 */
	public static function from(
		mixed $value
	): array
	{
		if (\is_array($value)) {
			return $value;
		}

		throw InvalidTypeException::typeError('array', $value);
	}

	/**
	 * @return array<mixed>
	 */
	public static function fromOrNull(
		mixed $value,
		bool $nullIfInvalid
	): ?array
	{
		if (\is_array($value)) {
			return $value;
		}

		if ($value === null) {
			return null;
		}

		try {
			return self::from($value);
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
	 * @return array<mixed>
	 */
	public static function extract(
		$data,
		string $key
	): array
	{
		$value = ExtractableHelpers::extractValue($data, $key);

		try {
			return self::from($value);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
	 * @return array<mixed>|null
	 */
	public static function extractOrNull(
		$data,
		string $key,
		bool $nullIfInvalid = false
	): ?array
	{
		$value = ExtractableHelpers::extractValueOrNull($data, $key);

		if ($value === null) {
			return null;
		}

		try {
			return self::fromOrNull($value, $nullIfInvalid);
		} catch (InvalidTypeException $exception) {
			throw $exception->wrap($key);
		}
	}

}
