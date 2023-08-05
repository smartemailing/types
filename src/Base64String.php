<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class Base64String implements ToStringInterface, ComparableInterface
{

	use StringExtractableTrait;
	use ToStringTrait;
	use StringComparableTrait;

	private function __construct(
		private string $value
	)
	{
		if (!$this->isValid($value)) {
			throw new InvalidTypeException('Invalid Base64 string');
		}
	}

	public static function encode(
		string $value
	): self
	{
		return new static(
			\base64_encode($value)
		);
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function getDecodedValue(): string
	{
		$value = \base64_decode($this->value, true);

		if ($value === false) {
			throw new InvalidTypeException('Unable to decode Base64');
		}

		return $value;
	}

	private function isValid(
		string $value
	): bool
	{
		return \base64_decode($value, true) !== false;
	}

}
