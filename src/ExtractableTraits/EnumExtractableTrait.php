<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

use Consistence\Enum\Enum;

trait EnumExtractableTrait
{

	use ExtractableTrait;

	/**
	 * @param mixed $value
	 * @return \Consistence\Enum\Enum
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
	 */
	abstract public static function get(
		$value
	): Enum;

	/**
	 * @param mixed $data
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
	 * @return static
	 */
	final public static function from(
		mixed $data
	): static {
		if ($data instanceof self) {
			return $data;
		}

		return static::get($data);
	}/** @noinspection ReturnTypeCanBeDeclaredInspection */

}
