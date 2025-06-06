<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Strings;
use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class Guid implements ToStringInterface, ComparableInterface
{

	use StringExtractableTrait;
	use ToStringTrait;
	use StringComparableTrait;

	private string $value;

	private function __construct(
		string $value
	) {
		if (\preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $value) !== 1) {
			throw new InvalidTypeException('Invalid guid value');
		}

		$this->value = Strings::lower($value);
	}

	public static function fromHex32(
		Hex32 $hex32
	): Guid {
		$parts = \str_split(
			$hex32->getValue(),
			4
		);

		return self::from(
			\sprintf(
				'%s%s-%s-%s-%s-%s%s%s',
				...$parts // phpcs:disable SlevomatCodingStandard.PHP.OptimizedFunctionsWithoutUnpacking.UnpackingUsed
			)
		);
	}

	public function getValue(): string
	{
		return $this->value;
	}

}
