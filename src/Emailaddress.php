<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Nette\Utils\Strings;
use Nette\Utils\Validators;

final class Emailaddress implements ToStringInterface
{

	use ObjectMixinTrait;
	use StringExtractableTrait;
	use ToStringTrait;

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @var string
	 */
	private $localPart;

	/**
	 * @var \SmartEmailing\Types\Domain
	 */
	private $domain;

	private function __construct(
		string $value
	) {
		try {
			$ok = $this->initialize($value);
		} catch (InvalidTypeException $e) {
			$ok = false;
		}
		if (!$ok) {
			throw new InvalidEmailaddressException('Invalid emailaddress: ' . $value);
		}
	}

	public static function preprocessEmailaddress(
		string $emailaddress
	): string {
		$sanitized = Strings::lower(
			Strings::toAscii(
				Strings::trim(
					$emailaddress
				)
			)
		);
		return \strtr(
			$sanitized,
			[
				'>' => '',
				'<' => '',
			]
		);
	}

	public function getLocalPart(): string
	{
		return $this->localPart;
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function getDomain(): Domain
	{
		return $this->domain;
	}

	private function initialize(
		string $emailaddress
	): bool {
		$emailaddress = self::preprocessEmailaddress($emailaddress);

		if (
			Strings::startsWith($emailaddress, '-')
			|| !Strings::contains($emailaddress, '@')
			|| Strings::contains($emailaddress, '"')
			|| Strings::contains($emailaddress, ' ')
			|| !Validators::isEmail($emailaddress)
		) {
			return false;
		}

		if (\strcmp($emailaddress, Strings::toAscii($emailaddress)) !== 0) {
			return false;
		}

		$exploded = \explode('@', $emailaddress);

		if (\count($exploded) !== 2) {
			return false;
		}
		[$this->localPart, $domain] = $exploded;

		$this->domain = Domain::from($domain);

		$this->value = $emailaddress;

		return true;
	}

}
