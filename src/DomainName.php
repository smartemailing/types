<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

final class DomainName extends Domain
{
	protected function isValid(
		string $value
	): bool {
		return \preg_match('/^([_a-z\\d](-*[_a-z\\d])*)(\\.([_a-z\\d](-*[_a-z\\d])*))*$/i', $value) //valid chars check
			&& \preg_match('/^.{1,253}$/', $value)// overall length check
			&& \preg_match('/^[^\\.]{1,63}(\\.[^\\.]{1,63})*$/', $value);
	}

}
