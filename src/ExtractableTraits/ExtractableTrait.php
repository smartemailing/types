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
	 * @return self
	 */
	abstract public static function from(
		mixed $data
	);

	/**
	 * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
	 * @return self
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function extract(
		$data,
		string $key
	) {
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
	 * @return self|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function fromOrNull(
		mixed $value,
		bool $getNullIfInvalid = false
	) {
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
	 * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
	 * @return self|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function extractOrNull(
		$data,
		string $key,
		bool $nullIfInvalid = false
	) {
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
	 * @return array<self>
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
	 * @return array<self>
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
	 * @param array<mixed> $data
	 * @return array<self>
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
