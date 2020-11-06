<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class Guid implements ToStringInterface
{

	use StringExtractableTrait;
	use ToStringTrait;

	/**
	 * @var string
	 */
	private $value;

	private function __construct(
		string $value
	) {
		if (!\preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $value)) {
			throw new InvalidTypeException('Invalid guid value');
		}

		$this->value = $value;
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
				...$parts
			)
		);
	}

	public function getValue(): string
	{
		return $this->value;
	}

}
