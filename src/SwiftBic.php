<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Nette\Utils\Strings;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class SwiftBic implements ToStringInterface
{

	use ObjectMixinTrait;
	use ToStringTrait;
	use StringExtractableTrait;

	/**
	 * @var string
	 */
	private $value;

	public function __construct(string $value)
	{
		$this->value = $value;

		if (!$this->isValid($this->value)) {
			throw new InvalidTypeException('Invalid Swift/Bic: ' . $value);
		}
	}

	public function getValue(): string
	{
		return $this->value;
	}

	private function isValid(string $value): bool
	{
		return (bool) Strings::match(
			$value,
			'/^([a-zA-Z]){4}([a-zA-Z]){2}([0-9a-zA-Z]){2}([0-9a-zA-Z]{3})?$/'
		);
	}

}
