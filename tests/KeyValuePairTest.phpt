<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class KeyValuePairTest extends TestCase
{

	public function test1(): void
	{
		$data = [
			'key' => 'X-Header-Name',
			'value' => 'cool value',
		];

		$keyValuePair = KeyValuePair::from($data);
		Assert::type(KeyValuePair::class, $keyValuePair);

		Assert::equal('X-Header-Name', $keyValuePair->getKey());
		Assert::equal('cool value', $keyValuePair->getValue());

		Assert::equal($data, $keyValuePair->toArray());
	}

}

(new KeyValuePairTest())->run();
