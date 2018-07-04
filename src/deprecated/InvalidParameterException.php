<?php

declare(strict_types = 1);

namespace SmartSelling\Parameters;

/*
 *
 * All contents of this file are deprecated and will be removed in the future
 *
 *
 */

/** @noinspection ClassConstantCanBeUsedInspection */

use Consistence\Type\ObjectMixinTrait;

if (!\class_exists('SmartSelling\Parameters\InvalidParameterException')) {
	/**
	 * Class InvalidParameterException
     *
     * @package SmartSelling\Parameters
	 * @deprecated
	 */
	class InvalidParameterException extends \RuntimeException
	{

		use ObjectMixinTrait;

	}
}

