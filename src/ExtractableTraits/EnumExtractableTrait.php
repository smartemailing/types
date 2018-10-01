<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\ExtractableTraits;

use Consistence\Enum\Enum;

trait EnumExtractableTrait
{

	use ExtractableTrait;

	/**
	 * @param mixed $data
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
	 * @return self
	 */
	final public static function from(
		$data
	): self {
		if ($data instanceof self) {
			return $data;
		}

		return self::get($data);
	}
	/** @noinspection ReturnTypeCanBeDeclaredInspection */

	/**
	 * @param mixed $value
	 * @return \Consistence\Enum\Enum
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
	 */
	abstract public static function get(
		$value
	): Enum;

}
