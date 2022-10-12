<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Strings;
use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class IpAddress implements ToStringInterface, ComparableInterface
{

	use StringExtractableTrait;
	use ToStringTrait;
	use StringComparableTrait;

	private string $value;

	private int $version;

	private function __construct(
		string $value
	) {
		$this->initialize($value);
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function getVersion(): int
	{
		return $this->version;
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
