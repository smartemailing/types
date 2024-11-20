<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/bootstrap.php';

final class SwiftBicTest extends TestCase
{

	public function testValidIban(): void
	{
		foreach ($this->getValidIbanValues() as $validIbanValue) {
			Assert::noError(static fn () => SwiftBic::from($validIbanValue));
		}
	}

	public function testInvalidIban(): void
	{
		foreach ($this->getInvalidIbanValues() as $invalidIbanValue) {
			Assert::exception(static function () use ($invalidIbanValue): void {
				SwiftBic::from($invalidIbanValue);
			}, InvalidTypeException::class);
		}
	}

	/**
	 * @return array<string>
	 */
	private function getValidIbanValues(): array
	{
		return [
			'GIBACZPX',
			'UNCRSKBXXXX',
			'UNCRSKBX',
		];
	}

	/**
	 * @return array<string>
	 */
	private function getInvalidIbanValues(): array
	{
		return [
			'GIBACZP',
			'IBACZPX',
			'UNCRSKBXX',
		];
	}

}

(new SwiftBicTest())->run();
