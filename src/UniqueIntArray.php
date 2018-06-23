<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;

final class UniqueIntArray implements \Countable, \IteratorAggregate
{

	use ObjectMixinTrait;
	use ArrayExtractableTrait;
	use UniqueArrayFeatures;

	/**
	 * @var bool[]
	 */
	private $valuesPresenceMap;

	/**
	 * @param mixed[] $data
	 */
	private function __construct(array $data = [])
	{
		$this->valuesPresenceMap = [];
		foreach ($data as $value) {
			$this->add($this->getIntValue($value));
		}
	}

	/**
	 * @param mixed[] $data
	 * @param string $key
	 * @return \SmartEmailing\Types\UniqueIntArray
	 */
	public static function extractNotEmpty(
		array $data,
		string $key
	): self {
		$self = self::extract(
			$data,
			$key
		);
		if ($self->isEmpty()) {
			throw InvalidTypeException::cannotBeEmptyError($key);
		}
		return $self;
	}

	/**
	 * @param mixed $value
	 * @return int
	 */
	private function getIntValue($value): int
	{
		if (\is_int($value)) {
			return $value;
		}
		if (!\is_scalar($value)) {
			throw InvalidTypeException::typeError('all members of array to be int', $value);
		}
		if ($value === ((string) (int) $value)) {
			return (int) $value;
		}
		throw InvalidTypeException::typeError('all members of array to be int', $value);
	}

	public function getIterator(): \Traversable
	{
		return new \RecursiveArrayIterator($this->getValues());
	}

	public function count(): int
	{
		return \count($this->valuesPresenceMap);
	}

	/**
	 * @return int[]
	 */
	public function getValues(): array
	{
		return \array_keys($this->valuesPresenceMap);
	}

	/**
	 * @return int[]
	 */
	public function toArray(): array
	{
		return $this->getValues();
	}

	public function add(
		int $id
	): bool {
		if (!isset($this->valuesPresenceMap[$id])) {
			$this->valuesPresenceMap[$id] = true;
			return true;
		}
		return false;
	}

	public function remove(int $id): void
	{
		unset($this->valuesPresenceMap[$id]);
	}

	public function contains(int $id): bool
	{
		return isset($this->valuesPresenceMap[$id]);
	}

	public function isEmpty(): bool
	{
		return empty($this->valuesPresenceMap);
	}

	public function orderASC(): void
	{
		\ksort($this->valuesPresenceMap);
	}

	/**
	 * @param int $chunkSize
	 * @return \SmartEmailing\Types\UniqueIntArray[]
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
