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
		$value = PrimitiveTypes::extractInt($data, 'value');

		$this->value = $value;
		$this->unit = TimeUnit::extract($data, 'unit');

		$now = new \DateTimeImmutable();
		$end = $now->modify('+' . $this->getDateTimeModify());
		$diff = $end->getTimestamp() - $now->getTimestamp();
		$this->lengthInSeconds = (int) \abs($diff);
	}

	public static function fromDateTimeModify(string $dateTimeModify): self
	{
		$matches = Strings::match($dateTimeModify, '/^(-?|\+?)(\d+)\s+(.+)/');

		if (!$matches) {
			throw new InvalidTypeException('Duration: ' . $dateTimeModify . '  is not in valid format.');
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
