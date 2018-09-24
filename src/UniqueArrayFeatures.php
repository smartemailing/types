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


	public function merge(
		self $toBeMerged
	): self {
		$dolly = clone $this;

		foreach ($toBeMerged->getValues() as $value) {
			$dolly->add($value);
		}

		return $dolly;
	}

	public function deduct(
		self $toBeDeducted
	): self {
		$dolly = clone $this;

		foreach ($toBeDeducted->getValues() as $value) {
			$dolly->remove($value);
		}

		return $dolly;
	}

}
