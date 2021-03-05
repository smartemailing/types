<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use Nette\Utils\Strings;
use Nette\Utils\Validators;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class Emailaddress implements ToStringInterface
{

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
	)
	{
		try {
			$ok = $this->initialize($value);
		} catch (\Throwable $e) {
			$ok = false;
		}

		if (!$ok) {
			throw new InvalidEmailaddressException('Invalid emailaddress: ' . $value);
		}
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

	public static function preprocessEmailaddress(
		string $emailaddress
	): string
	{
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

	private function initialize(
		string $emailaddress
	): bool
	{
		$emailaddress = self::preprocessEmailaddress($emailaddress);

		if (
			!Strings::contains($emailaddress, '@')
			|| Strings::contains($emailaddress, '"')
			|| Strings::contains($emailaddress, ' ')
			|| !Validators::isEmail($emailaddress)
		) {
			return false;
		}

		$validator = new EmailValidator();

		$isValid = $validator->isValid(
			$emailaddress,
			new RFCValidation()
		);

		if (!$isValid) {
			return false;
		}

		$exploded = \explode('@', $emailaddress);

		[$this->localPart, $domain] = $exploded;

		$this->domain = Domain::from($domain);

		$this->value = $emailaddress;

		return true;
	}

}
