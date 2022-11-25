<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Nette\Http\Url;
use Nette\InvalidArgumentException;
use Nette\Utils\Validators;
use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\StringExtractableTrait;
use SmartEmailing\Types\Helpers\StringHelpers;

final class UrlType implements ToStringInterface, ComparableInterface
{

	use StringExtractableTrait;
	use ToStringTrait;
	use StringComparableTrait;

	private Url $url;

	private function __construct(
		string $value
	)
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
			static fn ($match): string => \urlencode($match[0]),
			$value
		);

		// Nette\Utils 2.4 has a bug, URLs without slash in empty path are treated as invalid
		$value = $this->addSlashToPathOrFail($value) ?? $value;

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
	 * @deprecated use getQueryParameter instead
	 */
	public function getParameter(
		string $name
	): ?string
	{
		return $this->url->getQueryParameter($name) ?? null;
	}

	public function getBaseUrl(): string
	{
		return $this->url->getBaseUrl();
	}

	/**
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
	 * @param array<string> $names
	 */
	public function hasParameters(
		array $names
	): bool
	{
		$parameters = \array_keys($this->url->getQueryParameters());

		foreach ($names as $name) {
			if (!\in_array($name, $parameters, true)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * @return array<mixed>
	 */
	public function getParameters(): array
	{
		return $this->url->getQueryParameters();
	}

	public function withQueryParameter(
		string $name,
		mixed $value
	): self
	{
		$dolly = clone $this;
		$dolly->url->setQueryParameter(
			$name,
			$value
		);

		return $dolly;
	}

	/**
	 * @deprecated use withHostName
	 */
	public function withHost(
		Domain $host
	): self
	{
		$dolly = clone $this;
		$dolly->url->setHost(
			$host->getValue()
		);

		return $dolly;
	}

	public function withHostName(
		HostName $host
	): self
	{
		$dolly = clone $this;
		$dolly->url->setHost(
			$host->getValue()
		);

		return $dolly;
	}

	public function withScheme(
		string $scheme
	): self
	{
		$dolly = clone $this;
		$dolly->url->setScheme(
			$scheme
		);

		return $dolly;
	}

	public function withPath(
		string $path
	): self
	{
		$dolly = clone $this;
		$dolly->url->setPath(
			$path
		);

		return $dolly;
	}

	public function getQueryParameter(
		string $name,
		mixed $default = null
	): mixed
	{
		return $this->url->getQueryParameter($name) ?? $default;
	}

	public function getValue(): string
	{
		return $this->url->getAbsoluteUrl();
	}

	private function addSlashToPathOrFail(
		string $value
	): ?string
	{
		$urlParts = \parse_url($value);

		if ($urlParts === false) {
			return null;
		}

		return $this->buildUrl($urlParts);
	}

	/**
	 * @param array<string, string|int> $urlParts
	 */
	private function buildUrl(
		array $urlParts
	): string
	{
		$scheme = isset($urlParts['scheme'])
			? $urlParts['scheme'] . '://'
			: '';
		$host = $urlParts['host'] ?? '';
		$port = isset($urlParts['port'])
			? ':' . $urlParts['port']
			: '';
		$user = $urlParts['user'] ?? '';
		$pass = isset($urlParts['pass'])
			? ':' . $urlParts['pass']
			: '';
		$pass = $user || $pass
			? $pass . '@'
			: '';
		$path = $urlParts['path'] ?? '/';
		$query = isset($urlParts['query'])
			? '?' . $urlParts['query']
			: '';
		$fragment = isset($urlParts['fragment'])
			? '#' . $urlParts['fragment']
			: '';

		return $scheme . $user . $pass . $host . $port . $path . $query . $fragment;
	}

	public function __clone()
	{
		$this->url = clone $this->url;
	}

}
