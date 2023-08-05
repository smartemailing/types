<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Utils\Json;
use Nette\Utils\JsonException;
use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\ExtractableTrait;

final class JsonString implements ToStringInterface, ComparableInterface
{

	use ExtractableTrait;
	use ToStringTrait;
	use StringComparableTrait;

	private function __construct(
		private string $value
	)
	{
		if (!$this->isValid($value)) {
			throw new InvalidTypeException('Invalid JSON string');
		}
	}

	/**
	 * @param string|mixed|array<mixed> $data
	 * @throws \SmartEmailing\Types\InvalidTypeException
	 */
	public static function from(
		$data
	): JsonString
	{
		if ($data instanceof self) {
			return $data;
		}

		$string = StringType::fromOrNull($data, true);

		if (\is_string($string)) {
			return new static($string);
		}

		$array = Arrays::fromOrNull($data, true);

		if (\is_array($array)) {
			return self::encode($data);
		}

		throw InvalidTypeException::typesError(['string', 'array'], $data);
	}

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

	/**
	 * @return mixed|array<mixed>
	 */
	public function getDecodedValue()
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
		} catch (JsonException $e) {
			return false;
		}
	}

}
