<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Nette\Utils\Strings;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class IpAddress implements ToStringInterface
{

	use ObjectMixinTrait;
	use StringExtractableTrait;
	use ToStringTrait;

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @var int
	 */
	private $version;

	private function __construct(
		string $value
	) {
		$this->initialize($value);
	}

	private function isValidIpV4(
		string $value
	): bool {
		return (bool) \preg_match(
			'~^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$~',
			$value
		);
	}

	private function isValidIpV6(
		string $value
	): bool {
		return (bool) \preg_match(
			'~^(((?=(?>.*?(::))(?!.+\3)))\3?|([\dA-F]{1,4}(\3|:(?!$)|$)|\2))(?4){5}((?4){2}|((2[0-4]|1\d|[1-9])?\d|25[0-5])(\.(?7)){3})\z~i',
			$value
		);
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function getVersion(): int
	{
		return $this->version;
	}

	private function initialize(
		string $value
	): bool {
		$value = Strings::trim($value);
		$value = Strings::lower($value);
		$value = \strtr(
			$value,
			[
				'[' => '',
				']' => '',
			]
		);

		if ($this->isValidIpV4($value)) {
			$this->value = $value;
			$this->version = 4;

			return true;
		}

		if ($this->isValidIpV6($value)) {
			$this->value = $value;
			$this->version = 6;

			return true;
		}

		throw new InvalidTypeException('Invalid IP address: ' . $value);
	}

}
