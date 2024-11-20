<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

abstract class BoolArray implements ExtractableTypeInterface
{

	/**
	 * @return array<bool>
	 */
	final public static function from(
		mixed $value
	): array {
		$array = Arrays::from($value);

		$return = [];

		foreach ($array as $index => $item) {
			$return[$index] = BoolType::from($item);
		}

		return $return;
	}

	/**
	 * @return array<bool>|null
	 */
	final public static function fromOrNull(
		mixed $value,
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
	 * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
	 * @return array<bool>
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extract(
		array|\ArrayAccess $data,
		string $key
	): array {
		$value = Arrays::extract($data, $key);

		try {
			return self::from($value);
		} catch (InvalidTypeException $e) {
			throw $e->wrap($key);
		}
	}

	/**
	 * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
	 * @return array<bool>|null
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	final public static function extractOrNull(
		array|\ArrayAccess $data,
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
