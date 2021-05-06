<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Strings;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class HostName implements ToStringInterface
{

	use StringExtractableTrait;
	use ToStringTrait;

	private string $value;

	private function __construct(
		string $value
	)
	{
		$value = Strings::lower($value);
		$value = Strings::trim($value);

		if (!$this->isValid($value)) {
			throw new InvalidTypeException('Invalid hostname: ' . $value);
		}

		$this->value = $value;
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function getSecondLevelDomain(): HostName
	{
		$parts = \explode('.', $this->value);
		$numberOfKeptParts = 2;

		if (\count($parts) > 2 && \end($parts) === 'uk') {
			$numberOfKeptParts = 3;
		}

		$secondLevelParts = \array_slice($parts, -$numberOfKeptParts, $numberOfKeptParts);

		return self::from(\implode('.', $secondLevelParts));
	}

	private function isValid(
		string $value
	): bool {
		return \preg_match('/^([a-z\\d](-*[a-z\\d])*)(\\.([a-z\\d](-*[a-z\\d])*))*$/i', $value) //valid chars check
			&& \preg_match('/^.{1,253}$/', $value)// overall length check
			&& \preg_match('/^[^\\.]{1,63}(\\.[^\\.]{1,63})*$/', $value);
	}

}
