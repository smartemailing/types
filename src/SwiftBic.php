<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Strings;
use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class SwiftBic implements ToStringInterface, ComparableInterface
{

	use ToStringTrait;
	use StringExtractableTrait;
	use StringComparableTrait;

	public function __construct(
		private string $value
	)
	{
		if (!$this->isValid($this->value)) {
			throw new InvalidTypeException('Invalid Swift/Bic: ' . $value);
		}
	}

	public function getValue(): string
	{
		return $this->value;
	}

	private function isValid(
		string $value
	): bool
	{
		return (bool) Strings::match(
			$value,
			'/^([a-zA-Z]){4}([a-zA-Z]){2}([0-9a-zA-Z]){2}([0-9a-zA-Z]{3})?$/'
		);
	}

}
