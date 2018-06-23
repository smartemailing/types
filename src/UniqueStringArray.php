<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;

final class UniqueStringArray implements \Countable, \IteratorAggregate
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
			$this->add($this->getStringValue($value));
		}
	}

	/**
	 * @param mixed $value
	 * @return string
	 */
	private function getStringValue($value): string
	{
		if (\is_string($value)) {
			return $value;
		}
		if (!\is_scalar($value)) {
			throw InvalidTypeException::typeError('all members of array to be string', $value);
		}
		return (string) $value;
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
	 * @return string[]
	 */
	public function getValues(): array
	{
		// numeric keys are implicitly converted to int. We must be sure to return strings.
		return \array_map(
			'\strval',
			\array_keys($this->valuesPresenceMap)
		);
	}

	/**
	 * @return string[]
	 */
	public function toArray(): array
	{
		return $this->getValues();
	}

	public function removeDuplicities(): void
	{
		$this->valuesPresenceMap = \array_unique($this->valuesPresenceMap);
	}

	public function add(
		string $id
	): bool {
		if (!isset($this->valuesPresenceMap[$id])) {
			$this->valuesPresenceMap[$id] = true;
			return true;
		}
		return false;
	}

	public function remove(string $id): void
	{
		unset($this->valuesPresenceMap[$id]);
	}

	public function isEmpty(): bool
	{
		return empty($this->valuesPresenceMap);
	}

	public function contains(
		string $value
	): bool {
		return isset($this->valuesPresenceMap[$value]);
	}

	public function merge(
		UniqueStringArray $toBeMerged
	): void {
		foreach ($toBeMerged->getValues() as $value) {
			$this->add($value);
		}
	}

}
