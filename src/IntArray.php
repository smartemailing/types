<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

abstract class IntArray implements ExtractableTypeInterface
{

	/**
	 * @param mixed $value
	 * @return array<int>
	 */
	final public static function get(
		$value
	): array {
		$array = Arrays::get($value);

		$return = [];

		foreach ($array as $index => $item) {
			$return[$index] = IntType::get($item);
		}

		return $return;
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return array<int>|null
	 */
	final public static function getOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?array {
		$array = Arrays::getOrNull($value, $nullIfInvalid);

		if ($array === null) {
			return null;
		}

		$return = [];

		try {
			foreach ($array as $index => $item) {
				$return[$index] = IntType::get($item);
			}
		} catch (InvalidTypeException $e) {
			if ($nullIfInvalid) {
				return null;
			}

			throw $e;
		}

		return $return;
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @return array<int>
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extract(
		array $data,
		string $key
	): array {
		$array = Arrays::extract($data, $key);

		try {
			$array = self::get($array);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}

		return $array;
	}

	/**
	 * @param array<mixed> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return array<int>|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractOrNull(
		array $data,
		string $key,
		bool $nullIfInvalid = false
	): ?array {
		$array = Arrays::extractOrNull($data, $key, $nullIfInvalid);

		if ($array === null) {
			return null;
		}

		return self::getOrNull($array, $nullIfInvalid);
	}

}
