<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Nette\Utils\Strings;
use SmartEmailing\Types\ExtractableTraits\ExtractableTrait;

final class Duration implements ToStringInterface
{

	use ObjectMixinTrait;
	use ExtractableTrait;

	/**
	 * @var int
	 */
	private $value;

	/**
	 * @var \SmartEmailing\Types\TimeUnit
	 */
	private $unit;

	/**
	 * @var int
	 */
	private $lengthInSeconds;

	/**
	 * @param mixed[] $data
	 */
	private function __construct(
		array $data
	) {
		$this->value = PrimitiveTypes::extractInt($data, 'value');
		$this->unit = TimeUnit::extract($data, 'unit');

		$now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
		$end = $now->modify('+' . $this->getDateTimeModify());
		$diff = $end->getTimestamp() - $now->getTimestamp();
		$this->lengthInSeconds = (int) \abs($diff);
	}

	/**
	 * @param mixed $data
	 * @return \SmartEmailing\Types\Duration
	 */
	public static function from(
		$data
	): Duration {
		if ($data instanceof self) {
			return $data;
		}

		$string = PrimitiveTypes::getStringOrNull($data, true);

		if (\is_string($string)) {
			return self::fromDateTimeModify($string);
		}

		$array = Arrays::getArrayOrNull($data, true);

		if (\is_array($array)) {
			return new self($data);
		}

		throw InvalidTypeException::typesError(['string', 'array'], $data);
	}

	public static function fromDateTimeModify(string $dateTimeModify): self
	{
		$matches = Strings::match($dateTimeModify, '/^(-?|\+?)(\d+)\s+(.+)/');

		if (!$matches) {
			throw new InvalidTypeException('Duration: ' . $dateTimeModify . '  is not in valid duration format.');
		}

		$value = PrimitiveTypes::extractInt($matches, '2');
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

	public function __toString(): string
	{
		return $this->getDateTimeModify();
	}

	/**
	 * @return mixed[]
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

}
