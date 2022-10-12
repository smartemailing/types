<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Comparable\ArrayComparableTrait;
use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;

final class KeyValuePair implements ToArrayInterface, ComparableInterface
{

	use ArrayExtractableTrait;
	use ArrayComparableTrait;

	private string $key;

	private string $value;

	/**
	 * @param array<string> $data
	 */
	private function __construct(
		array $data
	) {
		$this->key = StringType::extract($data, 'key');
		$this->value = StringType::extract($data, 'value');
	}

	public function getKey(): string
	{
		return $this->key;
	}

	public function getValue(): string
	{
		return $this->value;
	}

	/**
	 * @return array<mixed>
	 */
	public function toArray(): array
	{
		return [
			'key' => $this->key,
			'value' => $this->value,
		];
	}

}
