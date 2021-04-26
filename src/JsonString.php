<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Json;
use Nette\Utils\JsonException;
use SmartEmailing\Types\ExtractableTraits\ExtractableTrait;

final class JsonString implements ToStringInterface
{

	use ExtractableTrait;
	use ToStringTrait;

	private string $value;

	private function __construct(
		string $value
	)
	{
		if (!$this->isValid($value)) {
			throw new InvalidTypeException('Invalid JSON string');
		}

		$this->value = $value;
	}

	/**
	 * @return self
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function from(
		mixed $data
	): JsonString
	{
		if ($data instanceof self) {
			return $data;
		}

		$string = PrimitiveTypes::getStringOrNull($data, true);

		if (\is_string($string)) {
			return new static($string);
		}

		$array = Arrays::getArrayOrNull($data, true);

		if (\is_array($array)) {
			return self::encode($data);
		}

		throw InvalidTypeException::typesError(['string', 'array'], $data);
	}

	/**
	 * @return \SmartEmailing\Types\JsonString
	 */
	public static function encode(
		mixed $value,
		bool $oneLine = false
	): self
	{
		try {
			return new static(
				Json::encode(
					$value,
					$oneLine ? 0 : Json::PRETTY
				)
			);
		} catch (JsonException $e) {
			throw new InvalidTypeException($e->getMessage());
		}
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function getDecodedValue(): mixed
	{
		return Json::decode($this->value, Json::FORCE_ARRAY);
	}

	private function isValid(
		string $value
	): bool
	{
		try {
			Json::decode($value);

			return true;
		} catch (JsonException) {
			return false;
		}
	}

}
