<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

abstract class BoolArray implements ExtractableTypeInterface
{

	/**
	 * @param mixed $value
	 * @return array<bool>
	 */
	final public static function from(
		$value
	): array {
		$array = Arrays::from($value);

		$return = [];

		foreach ($array as $index => $item) {
			$return[$index] = BoolType::from($item);
		}

		return $return;
	}

	/**
	 * @param mixed $value
	 * @param bool $nullIfInvalid
	 * @return array<bool>|null
	 */
	final public static function fromOrNull(
		$value,
		bool $nullIfInvalid = false
	): ?array {
		$array = Arrays::fromOrNull($value, $nullIfInvalid);

		if ($array === null) {
			return null;
		}

		$return = [];

		try {
			foreach ($array as $index => $item) {
				$return[$index] = BoolType::from($item);
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
	 * @param array<mixed>|\ArrayAccess<mixed,mixed> $data
	 * @param string $key
	 * @return array<bool>
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extract(
		$data,
		string $key
	): array {
		$value = Arrays::extract($data, $key);

		try {
			$value = self::from($value);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}

		return $value;
	}

	/**
	 * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
	 * @param string $key
	 * @param bool $nullIfInvalid
	 * @return array<bool>|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractOrNull(
		$data,
		string $key,
		bool $nullIfInvalid = false
	): ?array {
		$value = Arrays::extractOrNull($data, $key, $nullIfInvalid);

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
