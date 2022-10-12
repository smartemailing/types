<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Helpers;

use ArrayAccess;
use SmartEmailing\Types\InvalidTypeException;

abstract class ExtractableHelpers
{

	/**
	 * @param array<mixed>|\ArrayAccess<mixed, mixed>|mixed $data
	 * @return mixed
	 */
	final public static function extractValue(
		$data,
		string $key
	) {
		if ($data instanceof ArrayAccess) {
			return self::extractValueFromArrayAccess($data, $key);
		}

		if (\is_array($data)) {
			return self::extractValueFromArray($data, $key);
		}

		throw InvalidTypeException::typesError(['array', \ArrayAccess::class], $data);
	}

	/**
	 * @param array<mixed>|\ArrayAccess<mixed, mixed>|mixed $data
	 * @return mixed
	 */
	final public static function extractValueOrNull(
		$data,
		string $key
	) {
		if ($data instanceof ArrayAccess) {
			return self::extractValueFromArrayAccessOrNull($data, $key);
		}

		if (\is_array($data)) {
			return self::extractValueFromArrayOrNull($data, $key);
		}

		throw InvalidTypeException::typesError(['array', \ArrayAccess::class], $data);
	}

	/**
	 * @param array<mixed> $data
	 * @return mixed
	 */
	private static function extractValueFromArray(
		array $data,
		string $key
	)
	{
		if (!\array_key_exists($key, $data)) {
			throw InvalidTypeException::missingKey($key);
		}

		return $data[$key];
	}

	/**
	 * @param \ArrayAccess<mixed, mixed> $data
	 * @return mixed
	 */
	private static function extractValueFromArrayAccess(
		ArrayAccess $data,
		string $key
	)
	{
		if (!$data->offsetExists($key)) {
			throw InvalidTypeException::missingKey($key);
		}

		return $data->offsetGet($key);
	}

	/**
	 * @param array<mixed> $data
	 * @return mixed
	 */
	private static function extractValueFromArrayOrNull(
		array $data,
		string $key
	)
	{
		return $data[$key] ?? null;
	}

	/**
	 * @param \ArrayAccess<mixed, mixed> $data
	 * @return mixed
	 */
	private static function extractValueFromArrayAccessOrNull(
		ArrayAccess $data,
		string $key
	)
	{
		if (!$data->offsetExists($key)) {
			return null;
		}

		return $data->offsetGet($key);
	}

}
