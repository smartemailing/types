<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

trait EnumExtractableTrait
{

	use ExtractableTrait;

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
	 * @return static
	 */
	final public static function from(
		mixed $data,
		mixed ...$params
	): static {
		if ($data instanceof self) {
			return $data;
		}

		return static::get($data);
	}/** @noinspection ReturnTypeCanBeDeclaredInspection */

}
