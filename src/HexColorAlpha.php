<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Strings;
use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class HexColorAlpha implements ToStringInterface, ComparableInterface
{

	use StringExtractableTrait;
	use ToStringTrait;
	use StringComparableTrait;

	private string $value;

	public function __construct(
		string $value
	)
	{
		$value = $this->preProcess($value);

		if (!$this->isValid($value)) {
			throw new InvalidTypeException('Invalid hex color string: ' . $value);
		}

		$value = $this->processAlpha($value);

		$this->value = $value;
	}

	public function getValue(): string
	{
		return $this->value;
	}

	private function isValid(
		string $value
	): bool
	{
		return (bool) \preg_match('#^\#([A-F0-9]{3,4}|[A-F0-9]{6}|[A-F0-9]{8})\z#', $value);
	}

	private function preProcess(
		string $value
	): string
	{
		return Strings::upper($value);
	}

	private function processAlpha(
		string $value
	): string
	{
		$hex = \ltrim($value, '#');
		$length = \strlen($hex);

		return match ($length) {
			8, 4 => '#' . $hex,
			6 => '#' . $hex . 'FF',
			3 => '#' . $hex . 'F',
			default => throw new InvalidTypeException('Invalid hex color length (' . $length . '): ' . $value),
		};
	}

}
