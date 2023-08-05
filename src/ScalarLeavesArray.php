<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Comparable\ArrayComparableTrait;
use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;
use SmartEmailing\Types\Helpers\ValidationHelpers;

final class ScalarLeavesArray implements ToArrayInterface, ComparableInterface
{

	use ArrayExtractableTrait;
	use ArrayComparableTrait;

	/**
	 * @param array<mixed> $data
	 */
	public function __construct(
		private array $data
	) {
		if (!ValidationHelpers::isScalarLeavesArray($data)) {
			throw new InvalidTypeException('Array must have all it\'s leaves scalar or null');
		}
	}

	/**
	 * @param array<mixed> $data
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

		return new self([]);
	}

	/**
	 * @return array<mixed>
	 */
	public function toArray(): array
	{
		return $this->data;
	}

}
