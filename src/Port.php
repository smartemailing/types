<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\IntExtractableTrait;

final class Port implements ToStringInterface
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
		if ($value < 0 || $value > 65535) {
			throw new InvalidTypeException('Invalid Port number: ' . $value);
		}

		$this->value = $value;
	}

	public function getValue(): int
	{
		return $this->value;
	}

}
