<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Helpers;

use SmartEmailing\Types\InvalidTypeException;

abstract class ExtractableHelpers
{

	/**
	 * @param array<mixed>|\ArrayAccess<string|int, mixed> $data
	 * @param string|int $key
	 * @return mixed
	 */
	final public static function extractValue(
		array | \ArrayAccess $data,
		string | int $key
	): mixed {
		if ($data instanceof \ArrayAccess) {
			if (!$data->offsetExists($key)) {
				throw InvalidTypeException::missingKey($key);
			}

			return $data->offsetGet($key);
		}

		if (!\is_array($data)) {
			throw InvalidTypeException::typeError('array|\ArrayAccess', $data);
		}

		if (!\array_key_exists($key, $data)) {
			throw InvalidTypeException::missingKey($key);
		}

		return $data[$key];
	}

}
