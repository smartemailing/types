<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Strings;
use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class ContentType implements ToStringInterface, ComparableInterface
{

	use StringExtractableTrait;
	use ToStringTrait;
	use StringComparableTrait;

	private string $value;

	private string $type;

	private string $subType;

	private function __construct(
		string $value
	)
	{
		$typeRegex = '[a-z]+';
		$subTypeRegex = '[a-z]{1}[0-9a-z\.\-\+]+';

		$match = Strings::match($value, '~^(' . $typeRegex . ')/(' . $subTypeRegex . ')$~');

		if ($match === null) {
			throw new InvalidTypeException('Invalid content type: ' . $value);
		}

		$this->value = StringType::extract($match, '0');
		$this->type = StringType::extract($match, '1');
		$this->subType = StringType::extract($match, '2');
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function getSubType(): string
	{
		return $this->subType;
	}

}
