<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Nette\Utils\Strings;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;
use SmartEmailing\Types\Helpers\StringHelpers;

final class ZipCode
{

	use ObjectMixinTrait;
	use StringExtractableTrait;
	use ToStringTrait;

	/**
	 * @var string
	 */
	private $value;

	private function __construct(
		string $value
	) {
		$value = StringHelpers::removeWhitespace($value);
		$value = Strings::upper($value);

		if (!$this->isValid($value)) {
			throw new InvalidTypeException('Invalid ZIP code: ' . $value);
		}

		$this->value = $value;
	}

	public function getValue(): string
	{
		return $this->value;
	}

	private function isValid(
		string $value
	): bool {
		$patterns = [
			'CZ_SK_US' => '/^[0-9]{5}$/',
			'UK' => '/^[0-9A-B]{2,4}[\-\s]{1}[0-9A-B]{3,4}$/',
		];

		foreach ($patterns as $pattern) {
			if (Strings::match($value, $pattern)) {
				return true;
			}
		}

		return false;
	}

}
