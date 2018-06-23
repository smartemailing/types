<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Nette\Http\Url;
use Nette\InvalidArgumentException;
use Nette\Utils\Validators;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;
use SmartEmailing\Types\Helpers\StringHelpers;

final class UrlType
{

	use ObjectMixinTrait;
	use StringExtractableTrait;
	use ToStringTrait;

	/**
	 * @var \Nette\Http\Url
	 */
	private $url;

	private function __construct(string $value)
	{
		$value = StringHelpers::sanitize($value);
		$value = \strtr(
			$value,
			[
				' ' => '%20',
			]
		);

		if (!Validators::isUrl($value)) {
			throw new InvalidTypeException('Invalid URL: ' . $value);
		}
		try {
			$this->url = new Url($value);
		} catch (InvalidArgumentException $e) {
			throw new InvalidTypeException('Invalid URL: ' . $value);
		}
	}

	public function getAuthority(): string
	{
		return $this->url->getAuthority();
	}

	public function getHost(): string
	{
		return $this->url->getHost();
	}

	public function getQueryString(): string
	{
		return $this->url->getQuery();
	}

	public function getPath(): string
	{
		return $this->url->getPath();
	}

	public function getAbsoluteUrl(): string
	{
		return $this->getValue();
	}

	public function getParameter(string $name): ?string
	{
		return $this->url->getQueryParameter($name, null);
	}

	public function getBaseUrl(): string
	{
		return $this->url->getBaseUrl();
	}

	public function toString(): string
	{
		return (string) $this->url;
	}

	public function getScheme(): string
	{
		return $this->url->getScheme();
	}

	/**
	 * @param string[] $names
	 * @return bool
	 */
	public function hasParameters(
		array $names
	): bool {
		$parameters = \array_keys($this->url->getQueryParameters());
		foreach ($names as $name) {
			if (!\in_array($name, $parameters, true)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * @param string $name
	 * @param mixed|null $default
	 * @return mixed
	 */
	public function getQueryParameter(
		string $name,
		$default = null
	) {
		return $this->url->getQueryParameter($name, $default);
	}

	public function getValue(): string
	{
		return $this->url->getAbsoluteUrl();
	}

}
