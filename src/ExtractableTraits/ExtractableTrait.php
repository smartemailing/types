<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

use SmartEmailing\Types\ExtractableHelpers;
use SmartEmailing\Types\Helpers\ValidationHelpers;
use SmartEmailing\Types\InvalidTypeException;
use SmartEmailing\Types\PrimitiveTypes;

trait ExtractableTrait
{

	/**
	 * @param mixed|mixed[] $data
	 * @param string $key
	 * @return self
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function extract(
		$data,
		string $key
	): self {
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
	 * @param mixed[] $data
	 * @param string $key
	 * @return self[]
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function extractArrayOf(
		array & $data,
		string $key
	): array {
		$typedArray = PrimitiveTypes::extractArray($data, $key);
		try {
			return self::getArrayOf($typedArray);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}
	}

	/**
	 * @param mixed[] $data
	 * @param string $key
	 * @return self[]
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function extractArrayOfOrEmpty(
		array & $data,
		string $key
	): array {
		if (!isset($data[$key])) {
			return [];
		}
		return self::extractArrayOf($data, $key);
	}

	/**
	 * @param mixed[] $array
	 * @return self[]
	 */
	public static function getArrayOf(
		array $array
	): array {
		$return = [];
		if (ValidationHelpers::isTypedObjectArray($array, static::class)) {
			return $array;
		}
		foreach ($array as $item) {
			if ($item instanceof self) {
				$return[] = $item;
			} else {
				$return[] = self::from($item);
			}
		}
		return $return;
	}

	/**
	 * @param string|mixed|mixed[] $data
	 * @return self
	 */
	abstract public static function from(
		$data
	): self;

	/**
	 * @param mixed $value
	 * @param bool $getNullIfInvalid
	 * @return null|self
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function fromOrNull(
		$value,
		bool $getNullIfInvalid = false
	): ?self {
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
	 * @param mixed|mixed[] $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return self|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function extractOrNull(
		$data,
		string $key,
		bool $nullIfInvalid = false // default value breaks code sniffer
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
