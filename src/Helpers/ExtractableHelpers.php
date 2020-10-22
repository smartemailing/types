<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Helpers;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\InvalidTypeException;

abstract class ExtractableHelpers
{

	use ObjectMixinTrait;

	/**
	 * @param mixed|mixed[] $data
	 * @param string $key
	 * @return mixed
	 */
	final public static function extractValue(
		$data,
		string $key
	) {
		if (!\is_array($data)) {
			throw InvalidTypeException::typeError('array', $data);
		}

		if (!\array_key_exists($key, $data)) {
			throw InvalidTypeException::missingKey($key);
		}

		return $data[$key];
	}

	/**
	 * @param mixed|mixed[] $data
	 * @param string|string[] $keys
	 * @return mixed
	 */
	final public static function extractValueVol2(
		$data,
		$keys
	) {
		if (!\is_array($data)) {
			throw InvalidTypeException::typeError('array', $data);
		}

		if (\is_string($keys)) {
			$keys = [$keys];
		}

		if ($keys === []) {
			throw InvalidTypeException::typeError('array', $data); // todo
		}

		$processedKeys = [];

		foreach ($keys as $key) {
			$processedKeys[] = $key;

			if (!\array_key_exists($key, $data)) {
				throw InvalidTypeException::missingKeys($processedKeys);
			}

			$data = $data[$key];
		}

		return $data;
	}

}
