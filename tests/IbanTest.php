<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/bootstrap.php';

final class IbanTest extends TestCase
{

	public function testValidIban(): void
	{
		foreach ($this->getValidIbanValues() as $validIbanValue) {
			$iban = Iban::from($validIbanValue);
			Assert::type(Iban::class, $iban);
			Assert::type('string', $iban->getFormatted());
			Assert::type('string', $iban->getValue());
			Assert::type('int', $iban->getChecksum());
			Assert::notEqual(0, $iban->getChecksum());
		}
	}

	public function testInvalidIban(): void
	{
		foreach ($this->getInvalidIbanValues() as $invalidIbanValue) {
			Assert::exception(function () use ($invalidIbanValue): void {
				Iban::from($invalidIbanValue);
			}, InvalidTypeException::class);
		}
	}

	/**
	 * @return string[]
	 */
	private function getValidIbanValues(): array
	{
		return [
			'CZ8508000000002677686023',
		];
	}

	/**
	 * @return string[]
	 */
	private function getInvalidIbanValues(): array
	{
		return [
			'8508000000002677686023',
			'CZ85080000000026776860',
		];
	}

}

(new IbanTest())->run();
