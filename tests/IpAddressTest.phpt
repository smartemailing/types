<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\InvalidTypeException;
use SmartEmailing\Types\IpAddress;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class IpAddressTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{

		$invalidValues = [
			'12345',
			'-testx@seznam.cz',
			'1.1.1.1.1',
			'192.168.0.260',
		];

		foreach ($invalidValues as $invalidValue) {
			Assert::throws(
				function () use ($invalidValue): void {
					IpAddress::from($invalidValue);
				},
				InvalidTypeException::class
			);
		}

		$validValues = [
			'192.168.0.1',
			'2001:0db8:0a0b:12f0:0000:0000:0000:0001',
			'2001:0DB8:0A0B:12F0:0000:0000:0000:0001',
			'[2001:0db8:0a0b:12f0:0000:0000:0000:0001]',
			'2001:db8:a0b:12f0::1',
		];

		foreach ($validValues as $validValue) {
			$ipAddressType = IpAddress::from($validValue);
			Assert::type(IpAddress::class, $ipAddressType);
		}
	}

}

(new IpAddressTest())->run();