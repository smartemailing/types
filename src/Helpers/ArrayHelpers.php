<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Helpers;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ToArrayInterface;

abstract class ArrayHelpers
{

	use ObjectMixinTrait;

	/**
	 * @param \SmartEmailing\Types\ToArrayInterface[] $arrayableCollection
	 * @return mixed[]
	 */
	final public static function collectionItemsToArray(
		array $arrayableCollection
	): array {
		$toArrayCallback = function (ToArrayInterface $toArray) {
			return $toArray->toArray();
		};
		return \array_map(
			$toArrayCallback,
			$arrayableCollection
		);
	}

}
