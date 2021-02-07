<?php

declare(strict_types = 1);

namespace SmartEmailing\Types\Helpers;

use SmartEmailing\Types\ToArrayInterface;
use SmartEmailing\Types\ToStringInterface;

abstract class ArrayHelpers
{

	/**
	 * @param array<\SmartEmailing\Types\ToArrayInterface> $arrayableCollection
	 * @return array<mixed>
	 */
	final public static function collectionItemsToArray(
		array $arrayableCollection
	): array {
		$toArrayCallback = static function (ToArrayInterface $toArray) {
			return $toArray->toArray();
		};

		return \array_map(
			$toArrayCallback,
			$arrayableCollection
		);
	}

	/**
	 * @param array<\SmartEmailing\Types\ToStringInterface> $stringableCollection
	 * @return array<string>
	 */
	final public static function stringExtractableCollectionToArray(
		array $stringableCollection
	): array {
		$toArrayCallback = static function (ToStringInterface $toString) {
			return (string) $toString;
		};

		return \array_map(
			$toArrayCallback,
			$stringableCollection
		);
	}

}
