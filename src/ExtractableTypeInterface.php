<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

interface ExtractableTypeInterface
{

	/**
	 * @return mixed
	 */
	public static function from(
		mixed $value
	);

	/**
	 * @return mixed
	 */
	public static function fromOrNull(
		mixed $value,
		bool $nullIfInvalid
	);

	/**
	 * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
	 * @return mixed
	 */
	public static function extract(
		$data,
		string $key
	);

	/**
	 * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
	 * @return mixed
	 */
	public static function extractOrNull(
		$data,
		string $key,
		bool $nullIfInvalid
	);

}
