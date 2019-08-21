<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Nette\Http\Url;
use Nette\InvalidArgumentException;
use Nette\Utils\Validators;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;
use SmartEmailing\Types\Helpers\StringHelpers;

final class UrlType implements ToStringInterface
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

		// urlencode non-ascii chars
		$value = (string) \preg_replace_callback(
			'/[^\x20-\x7f]/',
			static function ($match) {
				return \urlencode($match[0]);
			},
			$value
		);

		if (!Validators::isUrl($value)) {
			throw new InvalidTypeException('Invalid URL or missing protocol: ' . $value);
		}

		try {
			$this->url = new Url($value);
		} catch (InvalidArgumentException $e) {
			throw new InvalidTypeException('Invalid URL or missing protocol: ' . $value);
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

	/**
	 * @param string $name
	 * @return string|null
	 * @deprecated use getQueryParameter instead
	 */
	public function getParameter(string $name): ?string
	{
		return $this->url->getQueryParameter($name) ?? null;
	}

	public function getBaseUrl(): string
	{
		return $this->url->getBaseUrl();
	}

	/**
	 * @return string
	 * @deprecated use getValue or (string) type cast
	 */
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
	 * @return mixed[]
	 */
	public function getParameters(): array
	{
		return $this->url->getQueryParameters();
	}

	/**
	 * @param string $name
	 * @param mixed|null $value
	 * @return \SmartEmailing\Types\UrlType
	 */
	public function withQueryParameter(
		string $name,
		$value
	): self {
		$dolly = clone $this;
		$dolly->url->setQueryParameter(
			$name,
			$value
		);

		return $dolly;
	}

	public function withHost(
		Domain $host
	): self {
		$dolly = clone $this;
		$dolly->url->setHost(
			$host->getValue()
		);

		return $dolly;
	}

	public function withScheme(
		string $scheme
	): self {
		$dolly = clone $this;
		$dolly->url->setScheme(
			$scheme
		);

		return $dolly;
	}

	public function withPath(
		string $path
	): self {
		$dolly = clone $this;
		$dolly->url->setPath(
			$path
		);

		return $dolly;
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
		return $this->url->getQueryParameter($name) ?? $default;
	}

	public function getValue(): string
	{
		return $this->url->getAbsoluteUrl();
	}

	public function __clone()
	{
		$this->url = clone $this->url;
	}

}
