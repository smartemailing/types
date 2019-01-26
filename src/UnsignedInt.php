<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\IntExtractableTrait;

final class UnsignedInt implements ToStringInterface
{

	use ObjectMixinTrait;
	use IntExtractableTrait;
	use ToStringTrait;

	/**
	 * @var int
	 */
	private $value;

	public function __construct(
		int $value
	) {
		if ($value < 0 || $value > \PHP_INT_MAX) {
			throw new InvalidTypeException('Invalid unsigned integer: ' . $value);
		}

		$this->value = $value;
	}

	public function getValue(): int
	{
		return $this->value;
	}

}
