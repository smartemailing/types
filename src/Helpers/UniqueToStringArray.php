<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Helpers;

use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;
use SmartEmailing\Types\InvalidTypeException;
use SmartEmailing\Types\ToStringInterface;
use SmartEmailing\Types\UniqueArrayFeatures;

/*
 * This is not type, just helper for easier work with
 * unique arrays of \SmartEmailing\Types\ToStringInterface.
 */

/**
 * @implements \IteratorAggregate<\SmartEmailing\Types\ToStringInterface>
 */
final class UniqueToStringArray implements \Countable, \IteratorAggregate
{

	use UniqueArrayFeatures;
	use ArrayExtractableTrait;

	/**
	 * @var array<\SmartEmailing\Types\ToStringInterface>
	 */
	private array $objects;

	private string $type;

	/**
	 * @param array<\SmartEmailing\Types\ToStringInterface> $data
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	private function __construct(
		array $data = []
	)
	{
		$this->objects = [];

		foreach ($data as $value) {
			if (!$value instanceof ToStringInterface) {
				throw InvalidTypeException::typeError(
					'all members of array must implement ' . ToStringInterface::class,
					$value
				);
			}

			$this->add($value);
		}
	}

	/**
	 * @param array<\SmartEmailing\Types\Helpers\UniqueToStringArray> $uniqueToStringArrays
	 * @return \SmartEmailing\Types\Helpers\UniqueToStringArray
	 */
	public static function intersect(
		array $uniqueToStringArrays
	): self {
		if (\count($uniqueToStringArrays) === 1) {
			return \reset($uniqueToStringArrays);
		}

		$plainIntArrays = [];

		foreach ($uniqueToStringArrays as $uniqueToStringArray) {
			$plainIntArrays[] = $uniqueToStringArray->objects;
		}

		$result = \array_intersect_key(
			...$plainIntArrays
		);

		$output = new UniqueToStringArray([]);
		$output->objects = $result;

		return $output;
	}

	/**
	 * @param array<\SmartEmailing\Types\Helpers\UniqueToStringArray> $uniqueIntArrays
	 * @return \SmartEmailing\Types\Helpers\UniqueToStringArray
	 */
	public static function union(
		array $uniqueIntArrays
	): self {
		$result = [];

		foreach ($uniqueIntArrays as $uniqueIntArray) {
			foreach ($uniqueIntArray->objects as $key => $object) {
				$result[$key] = $object;
			}
		}

		$output = new self([]);
		$output->objects = $result;

		return $output;
	}

	/**
	 * @return \Traversable<\SmartEmailing\Types\ToStringInterface>
	 */
	public function getIterator(): \Traversable
	{
		return new \RecursiveArrayIterator($this->getValues());
	}

	public function count(): int
	{
		return \count($this->objects);
	}

	/**
	 * @return array<\SmartEmailing\Types\ToStringInterface>
	 */
	public function getValues(): array
	{
		return \array_values($this->objects);
	}

	/**
	 * @return array<\SmartEmailing\Types\ToStringInterface>
	 */
	public function toArray(): array
	{
		return $this->getValues();
	}

	public function add(
		ToStringInterface $valueObject
	): bool {
		$type = $valueObject::class;

		if (!isset($this->type)) {
			$this->type = $type;
		}

		if ($this->type !== $type) {
			throw InvalidTypeException::typeError(
				'all members of array must be of type ' . $this->type,
				$valueObject
			);
		}

		$key = $valueObject->__toString();

		if (!isset($this->objects[$key])) {
			$this->objects[$key] = $valueObject;

			return true;
		}

		return false;
	}

	public function remove(
		ToStringInterface $valueObject
	): void {
		$key = $valueObject->__toString();
		unset($this->objects[$key]);
	}

	public function isEmpty(): bool
	{
		return $this->objects === [];
	}

	public function contains(
		ToStringInterface $valueObject
	): bool {
		$key = $valueObject->__toString();

		return isset($this->objects[$key]);
	}

}
