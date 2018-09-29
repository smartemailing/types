<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;

final class DateTimeRange implements ToArrayInterface
{

	use ArrayExtractableTrait;
	use ObjectMixinTrait;

	/**
	 * @var \DateTimeImmutable
	 */
	private $from;

	/**
	 * @var \DateTimeImmutable
	 */
	private $to;

	/**
	 * @var int
	 */
	private $durationInSeconds;

	/**
	 * @param mixed[] $data
	 */
	private function __construct(
		array $data
	) {
		$this->from = DateTimesImmutable::extract($data, 'from');
		$this->to = DateTimesImmutable::extract($data, 'to');

		$compared = \strcmp(
			DateTimeFormatter::format($this->from),
			DateTimeFormatter::format($this->to)
		);

		if ($compared > 0) {
			throw new InvalidTypeException(self::class . ' cannot have negative duration');
		}

		$interval = $this->to->diff($this->from);

		$this->durationInSeconds
			= $interval->days * 86400
			+ $interval->h * 3600
			+ $interval->i * 60
			+ $interval->s;
	}

	public function getFrom(): \DateTimeImmutable
	{
		return $this->from;
	}

	public function getTo(): \DateTimeImmutable
	{
		return $this->to;
	}

	public function getDurationInSeconds(): int
	{
		return $this->durationInSeconds;
	}

	public function contains(
		\DateTimeInterface $dateTime
	): bool {
		$timestamp = $dateTime->getTimestamp();

		return $timestamp >= $this->getFrom()->getTimestamp() &&
			$timestamp <= $this->getTo()->getTimestamp();
	}

	/**
	 * @return mixed[]
	 */
	public function toArray(): array
	{
		return [
			'from' => DateTimeFormatter::format($this->from),
			'to' => DateTimeFormatter::format($this->to),
		];
	}

}
