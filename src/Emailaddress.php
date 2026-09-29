<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use Egulias\EmailValidator\Warning\EmailTooLong;
use Egulias\EmailValidator\Warning\LocalTooLong;
use Nette\Utils\Strings;
use Nette\Utils\Validators;
use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class Emailaddress implements ToStringInterface, ComparableInterface
{

	use StringExtractableTrait;
	use ToStringTrait;
	use StringComparableTrait;

	private string $value;

	private string $localPart;

	private HostName $hostName;

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

	/**
	 * @deprecated Use getHostName() instead
	 */
	public function getDomain(): Domain
	{
		return Domain::from($this->hostName->getValue());
	}

	public function getHostName(): HostName
	{
		return $this->hostName;
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

		// RFC 5321 section 4.5.3.1 length limits are reported by the validator only as warnings,
		// but addresses exceeding them cannot be delivered over SMTP.
		// Warnings are matched by class: the validator renumbers their keys while merging.
		foreach ($validator->getWarnings() as $warning) {
			if ($warning instanceof LocalTooLong || $warning instanceof EmailTooLong) {
				return false;
			}
		}

		$exploded = \explode('@', $emailaddress);

		[$this->localPart, $hostName] = $exploded;

		$this->hostName = HostName::from($hostName);

		$this->value = $emailaddress;

		return true;
	}

}
