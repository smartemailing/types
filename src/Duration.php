<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Nette\Utils\Strings;
use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;

final class Duration
{

	use ObjectMixinTrait;
	use ArrayExtractableTrait;

	public const MAX_VALUE = 1000000;

	/**
	 * @var int
	 */
	private $value;

	/**
	 * @var \SmartEmailing\Types\TimeUnit
	 */
	private $unit;

	/**
	 * @param mixed[] $data
	 */
	private function __construct(
		array $data
	) {
		$value = PrimitiveTypes::extractInt($data, 'value');
		if ($value < 0 || $value > self::MAX_VALUE) {
			throw new InvalidTypeException('Value is out of range: [0, ' . self::MAX_VALUE . ']');
		}
		$this->value = $value;
		$this->unit = TimeUnit::extract($data, 'unit');
	}

	public static function fromString(string $duration): self
	{
		$matches = Strings::match($duration, '/^(\d+)\s+(.+)/');

		if (!$matches) {
			throw new InvalidTypeException('Duration: ' . $duration . ' is not in valid format.');
		}

		$value = PrimitiveTypes::extractInt($matches, '1');
		$unit = TimeUnit::extract($matches, '2');

		return new self([
			'value' => $value,
			'unit' => $unit->getValue(),
		]);
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
	 * @return mixed[]
	 */
	public function toArray(): array
	{
		return [
			'value' => $this->value,
			'unit' => $this->unit->getValue(),
		];
	}

}
