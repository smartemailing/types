<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

use SmartEmailing\Types\Arrays;
use SmartEmailing\Types\Helpers\ExtractableHelpers;
use SmartEmailing\Types\Helpers\ValidationHelpers;
use SmartEmailing\Types\InvalidTypeException;

trait ExtractableTrait
{

	/**
	 * @param |mixed $data
	 * @return static
	 */
	abstract public static function from(
		$data
	): self;

	/**
	 * @param array<mixed>|\ArrayAccess<mixed,mixed> $data
	 * @param string $key
	 * @return static
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function extract(
		$data,
		string $key
	): self
	{
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
	 * @return static|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function fromOrNull(
		$value,
		bool $getNullIfInvalid = false
	): ?self
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
	 * @param array<mixed>|\ArrayAccess<mixed,mixed> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return static|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function extractOrNull(
		$data,
		string $key,
		bool $nullIfInvalid = false
	): ?self
	{
		$value = ExtractableHelpers::extractValueOrNull($data, $key);

		if ($value === null) {
			return null;
		}

		if (!$nullIfInvalid && $value === '') {
			return null;
		}

		if ($value instanceof self) {
			return $value;
		}

		try {
			return self::fromOrNull($value, $nullIfInvalid);
		} catch (InvalidTypeException $exception) {
			throw $exception->wrap($key);
		}
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @return array<static>
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function extractArrayOf(
		array $data,
		string $key
	): array
	{
		$typedArray = Arrays::extract($data, $key);

		try {
			return self::getArrayOf($typedArray);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @return array<static>
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function extractArrayOfOrEmpty(
		array $data,
		string $key
	): array
	{
		if (!isset($data[$key])) {
			return [];
		}

		return self::extractArrayOf($data, $key);
	}

	/**
	 * @param array<mixed> $array
	 * @return array<static>
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
	 * @return array<static>
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
	 * @param array<mixed> $data
	 * @param string $key
	 * @return array<static>
	 */
	public static function extractArrayOfSkipInvalid(
		array $data,
		string $key
	): array
	{
		$typedArray = Arrays::extract($data, $key);

		return self::getArrayOfSkipInvalid($typedArray);
	}

}
