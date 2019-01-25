<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class Base64String implements ToStringInterface
{

	use ObjectMixinTrait;
	use StringExtractableTrait;
	use ToStringTrait;

	/**
	 * @var string
	 */
	private $value;

	private function __construct(string $value)
	{
		if (!$this->isValid($value)) {
			throw new InvalidTypeException('Invalid Base64 string');
		}

		$this->value = $value;
	}

	private function isValid(string $value): bool
	{
		return \base64_decode($value, true) !== false;
	}

	public static function encode(
		string $value
	): self {
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
		return \base64_decode($this->value);
	}

}
