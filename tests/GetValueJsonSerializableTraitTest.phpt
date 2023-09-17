<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$stringExtractable = Base64String::encode('hello');

Assert::equal(
	$stringExtractable->getValue(),
	\json_decode((string) \json_encode($stringExtractable))
);

$intExtractable = Port::from(80);

Assert::equal(
	$intExtractable->getValue(),
	\json_decode((string) \json_encode($intExtractable))
);
