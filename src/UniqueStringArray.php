<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;

final class UniqueStringArray implements \Countable, \IteratorAggregate, ToArrayInterface
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
			try {
				$this->add(PrimitiveTypes::getString($value));
			} catch (InvalidTypeException $e) {
				throw InvalidTypeException::typeError('all members of array to be string', $value);
			}
		}
	}

	/**
	 * @return \Traversable|string[]
	 */
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

	/**
	 * @deprecated This method does nothing because array is already unique
	 */
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
		return $this->valuesPresenceMap === [];
	}

	public function contains(
		string $value
	): bool {
		return isset($this->valuesPresenceMap[$value]);
	}

}
