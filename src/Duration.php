<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Strings;
use SmartEmailing\Types\Comparable\ArrayComparableTrait;
use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\ExtractableTraits\ExtractableTrait;

final class Duration implements ToStringInterface, ToArrayInterface, ComparableInterface
{

	use ExtractableTrait;
	use ArrayComparableTrait;

	private int $value;

	private TimeUnit $unit;

	private int $lengthInSeconds;

	/**
	 * @param array<mixed> $data
	 */
	private function __construct(
		array $data
	) {
		$this->value = IntType::extract($data, 'value');
		$this->unit = TimeUnit::extract($data, 'unit');

		$now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
		$end = $now->modify('+' . $this->getDateTimeModify());
		$diff = $end->getTimestamp() - $now->getTimestamp();
		$this->lengthInSeconds = (int) \abs($diff);
	}

	public static function from(
		mixed $data
	): Duration {
		if ($data instanceof self) {
			return $data;
		}

		$string = StringType::fromOrNull($data, true);

		if (\is_string($string)) {
			return self::fromDateTimeModify($string);
		}

		$array = Arrays::fromOrNull($data, true);

		if (\is_array($array)) {
			return new self($data);
		}

		throw InvalidTypeException::typesError(['string', 'array'], $data);
	}

	public static function fromDateTimeModify(
		string $dateTimeModify
	): self
	{
		$matches = Strings::match($dateTimeModify, '/^(-?|\+?)(\d+)\s+(.+)/');

		if (!$matches) {
			throw new InvalidTypeException('Duration: ' . $dateTimeModify . '  is not in valid duration format.');
		}

		$value = IntType::extract($matches, '2');
		$unit = TimeUnit::extract($matches, '3');

		if ($matches[1] === '-') {
			$value *= -1;
		}

		return new static(
			[
				'value' => $value,
				'unit' => $unit->getValue(),
			]
		);
	}

	public function getValue(): int
	{
		return $this->value;
	}

	public function getUnit(): TimeUnit
	{
		return $this->unit;
	}

	public function getDateTimeModify(): string
	{
		return $this->value . ' ' . $this->unit->getValue();
	}

	/**
	 * @return array<mixed>
	 */
	public function toArray(): array
	{
		return [
			'value' => $this->value,
			'unit' => $this->unit->getValue(),
		];
	}

	public function getLengthInSeconds(): int
	{
		return $this->lengthInSeconds;
	}

	public function __toString(): string
	{
		return $this->getDateTimeModify();
	}

}
