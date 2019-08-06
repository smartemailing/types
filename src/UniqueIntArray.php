<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;

final class UniqueIntArray implements \Countable, \IteratorAggregate, ToArrayInterface
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
				$this->add(PrimitiveTypes::getInt($value));
			} catch (InvalidTypeException $e) {
				throw InvalidTypeException::typeError('all members of array to be int', $value);
			}
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
	 * @return \Traversable|int[]
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
		return $this->valuesPresenceMap === [];
	}

	public function orderASC(): void
	{
		\ksort($this->valuesPresenceMap);
	}

	/**
	 * @param \SmartEmailing\Types\UniqueIntArray[] $uniqueIntArrays
	 * @return \SmartEmailing\Types\UniqueIntArray
	 */
	public static function intersect(
		array $uniqueIntArrays
	): UniqueIntArray {
		if (\count($uniqueIntArrays) === 1) {
			return \reset($uniqueIntArrays);
		}

		$plainIntArrays = [];

		foreach ($uniqueIntArrays as $uniqueIntArray) {
			$plainIntArrays[] = $uniqueIntArray->valuesPresenceMap;
		}

		$result = \array_intersect_key(
			...$plainIntArrays
		);

		$output = new UniqueIntArray([]);
		$output->valuesPresenceMap = $result;

		return $output;
	}

	/**
	 * @param \SmartEmailing\Types\UniqueIntArray[] $uniqueIntArrays
	 * @return \SmartEmailing\Types\UniqueIntArray
	 */
	public static function union(
		array $uniqueIntArrays
	): UniqueIntArray {
		$result = [];

		foreach ($uniqueIntArrays as $uniqueIntArray) {
			foreach ($uniqueIntArray->valuesPresenceMap as $key => $true) {
				$result[$key] = $true;
			}
		}

		$output = new UniqueIntArray([]);
		$output->valuesPresenceMap = $result;

		return $output;
	}

}
