<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

interface ExtractableTypeInterface
{

	public static function from(
		mixed $value
	): mixed;

	public static function fromOrNull(
		mixed $value,
		bool $nullIfInvalid
	): mixed;

	/**
	 * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
	 */
	public static function extract(
		$data,
		string $key
	): mixed;

	/**
	 * @param array<mixed>|\ArrayAccess<mixed, mixed> $data
	 */
	public static function extractOrNull(
		$data,
		string $key,
		bool $nullIfInvalid
	): mixed;

}
