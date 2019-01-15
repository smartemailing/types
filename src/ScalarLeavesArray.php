<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;
use SmartEmailing\Types\Helpers\ValidationHelpers;

class ScalarLeavesArray implements ToArrayInterface
{

	use ObjectMixinTrait;
	use ArrayExtractableTrait;

	/**
	 * @var mixed[]
	 */
	private $data;

	/**
	 * @param mixed[] $data
	 */
	public function __construct(
		array $data
	) {
		if (!ValidationHelpers::isScalarLeavesArray($data)) {
			throw new InvalidTypeException('Array must have all it\'s leaves scalar or null');
		}

		$this->data = $data;
	}

	/**
	 * @return mixed[]
	 */
	public function toArray(): array
	{
		return $this->data;
	}

}
