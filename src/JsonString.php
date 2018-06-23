<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;

final class JsonString
{

	use ObjectMixinTrait;
	use StringExtractableTrait;
	use ToStringTrait;

	/**
	 * @var string
	 */
	private $value;

	private function __construct(
		string $value
	) {
		if (!$this->isValid($value)) {
			throw new InvalidTypeException('Invalid JSON string');
		}
		$this->value = $value;
	}

	private function isValid(string $value): bool
	{
		try {
			Json::decode($value);
			return true;
		} catch (JsonException $e) {
			return false;
		}
	}

	/** @noinspection PhpDocMissingThrowsInspection */

	/**
	 * @param mixed|mixed[] $value
	 * @param bool $oneLine
	 * @return \SmartEmailing\Types\JsonString
	 * @throws \Nette\Utils\JsonException
	 */
	public static function encode(
		$value,
		bool $oneLine = false
	): self {
		return new self(
			Json::encode(
				$value,
				$oneLine ? 0 : Json::PRETTY
			)
		);
	}

	public function getValue(): string
	{
		return $this->value;
	}

	/** @noinspection PhpDocMissingThrowsInspection */

	/**
	 * @return mixed|mixed[]
	 */
	public function getDecodedValue()
	{
		return Json::decode($this->value, Json::FORCE_ARRAY);
	}

}
