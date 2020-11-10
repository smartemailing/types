<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Strings;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class NonEmptyString implements ToStringInterface
{

	use StringExtractableTrait;
	use ToStringTrait;

	/**
	 * @var string
	 */
	private $value;

	public function __construct(string $value)
	{
		$value = Strings::trim($value);

		if ($value === '') {
			throw new InvalidTypeException('Value must be non empty string.');
		}

		$this->value = $value;
	}

	public function getValue(): string
	{
		return $this->value;
	}

}
