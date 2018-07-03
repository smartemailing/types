<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

trait UniqueArrayFeatures
{

	final public static function empty(): self
	{
		return self::from([]);
	}

	/**
	 * @param mixed[] $data
	 * @param string $key
	 * @return self
	 */
	public static function extractOrEmpty(
		array $data,
		string $key
	): self {
		$self = self::extractOrNull(
			$data,
			$key
		);
		if ($self) {
			return $self;
		}
		return self::empty();
	}

	/**
	 * @param int $chunkSize
	 * @return self[]
	 */
	public function split(
		int $chunkSize
	): array {
		$return = [];
		$chunks = \array_chunk(
			$this->getValues(),
			$chunkSize
		);
		foreach ($chunks as $chunk) {
			$return[] = self::from($chunk);
		}
		return $return;
	}

}
