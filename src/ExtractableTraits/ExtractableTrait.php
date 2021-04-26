<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

use SmartEmailing\Types\Arrays;
use SmartEmailing\Types\Helpers\ExtractableHelpers;
use SmartEmailing\Types\Helpers\ValidationHelpers;
use SmartEmailing\Types\InvalidTypeException;

trait ExtractableTrait
{

	abstract public static function from(
		mixed $data
	): self;

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @param string|int $key
	 * @return static
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function extract(
		array | \ArrayAccess $data,
		string | int $key
	): static {
		$value = ExtractableHelpers::extractValue($data, $key);

		if ($value instanceof self) {
			return $value;
		}

		try {
			return self::from($value);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}
	}

	/**
	 * @param mixed $value
	 * @param bool $getNullIfInvalid
	 * @return self|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function fromOrNull(
		mixed $value,
		bool $getNullIfInvalid = false
	): self | null
	{
		if ($value === null) {
			return null;
		}

		try {
			return self::from($value);
		} catch (InvalidTypeException $e) {
			if ($getNullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @param string|int $key
	 * @param bool $nullIfInvalid
	 * @return self|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function extractOrNull(
		array | \ArrayAccess $data,
		string | int $key,
		bool $nullIfInvalid = false
	): self | null
	{
		if (!\is_array($data)) {
			throw InvalidTypeException::typeError('array', $data);
		}

		if (!isset($data[$key])) {
			return null;
		}

		if (!$nullIfInvalid && $data[$key] === '') {
			return null;
		}

		return self::tryToExtract(
			$data,
			$key,
			$nullIfInvalid
		);
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @param string|int $key
	 * @return array<self>
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function extractArrayOf(
		array | \ArrayAccess $data,
		string | int $key
	): array
	{
		$typedArray = Arrays::extractArray($data, $key);

		try {
			return self::getArrayOf($typedArray);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @param string|int $key
	 * @return array<self>
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function extractArrayOfOrEmpty(
		array | \ArrayAccess $data,
		string | int $key
	): array
	{
		if (!isset($data[$key])) {
			return [];
		}

		return self::extractArrayOf($data, $key);
	}

	/**
	 * @param array<mixed> $array
	 * @return array<self>
	 */
	public static function getArrayOf(
		array $array
	): array
	{
		$return = [];

		if (ValidationHelpers::isTypedObjectArray($array, static::class)) {
			return $array;
		}

		foreach ($array as $item) {
			$return[] = $item instanceof self
				? $item
				: self::from($item);
		}

		return $return;
	}

	/**
	 * @param array<mixed> $array
	 * @return array<self>
	 */
	public static function getArrayOfSkipInvalid(
		array $array
	): array
	{
		$return = [];

		if (ValidationHelpers::isTypedObjectArray($array, static::class)) {
			return $array;
		}

		foreach ($array as $item) {
			try {
				$return[] = self::from($item);
			} catch (InvalidTypeException $e) {
				// exclude from result
			}
		}

		return $return;
	}

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @param string|int $key
	 * @return array<self>
	 */
	public static function extractArrayOfSkipInvalid(
		array | \ArrayAccess $data,
		string | int $key
	): array
	{
		$typedArray = Arrays::extractArray($data, $key);

		return self::getArrayOfSkipInvalid($typedArray);
	}

	/**
	 * @param mixed|array<mixed> $data
	 * @param string|int $key
	 * @param bool $nullIfInvalid
	 * @return self|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	private static function tryToExtract(
		mixed $data,
		string | int $key,
		bool $nullIfInvalid
	): self | null
	{
		try {
			return self::extract($data, $key);
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}
	}

}
