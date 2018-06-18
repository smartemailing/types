<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;

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

}
