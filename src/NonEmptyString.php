<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Strings;
use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class NonEmptyString implements ToStringInterface, ComparableInterface
{

	use StringExtractableTrait;
	use ToStringTrait;
	use StringComparableTrait;

	/**
	 * @var non-empty-string
	 */
	private string $value;

	public function __construct(
		string $value
	)
	{
		$value = Strings::trim($value);

		if ($value === '') {
			throw new InvalidTypeException('Value must be non empty string.');
		}

		$this->value = $value;
	}

	/**
	 * @return non-empty-string
	 */
	public function getValue(): string
	{
		return $this->value;
	}

}
