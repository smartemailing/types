<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

abstract class BoolArray implements ExtractableTypeInterface
{

	/**
	 * @param mixed $value
	 * @return array<bool>
	 */
	final public static function get(
		$value
	): array {
		$array = Arrays::get($value);

		$return = [];

		foreach ($array as $index => $item) {
			$return[$index] = BoolType::get($item);
		}

		return $return;
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return array<bool>|null
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
				$return[$index] = BoolType::get($item);
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
	 * @return array<bool>
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
	 * @return array<bool>|null
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
