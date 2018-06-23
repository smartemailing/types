<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
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

	public function getValue(): int
	{
		return $this->value;
	}

	public function getUnit(): TimeUnit
	{
		return $this->unit;
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
