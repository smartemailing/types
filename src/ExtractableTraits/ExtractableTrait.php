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
	 * @param string|mixed|array<mixed> $data
	 * @return static
	 */
	abstract public static function from(
		$data
	): self;

	/**
	 * @param mixed|array<mixed> $data
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
	 * @param mixed|array<mixed> $data
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

	/**
	 * @param mixed|array<mixed> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return static|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	private static function tryToExtract(
		$data,
		string $key,
		bool $nullIfInvalid
	): ?self
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
