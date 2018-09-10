<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class VatIdTest extends TestCase
{

	public function testDefault(): void
	{
		$vatId = VatId::from('cz123456789');

		Assert::type(VatId::class, $vatId);
		Assert::type(CountryCode::class, $vatId->getCountry());
		Assert::equal(CountryCode::CZ, $vatId->getCountry()->getValue());
		Assert::equal('123456789', $vatId->getVatNumber());
		Assert::equal('CZ123456789', $vatId->getValue());
		Assert::equal('CZ', $vatId->getPrefix());
	}

	public function testIsValid(): void
	{
		/** @var string $vatId */
		foreach ($this->getValidVatIds() as $vatId) {
			Assert::true(VatId::isValid($vatId));
		}
	}

	public function testIsInvalid(): void
	{
		/** @var string $vatId */
		foreach ($this->getInvalidVatIds() as $vatId) {
			Assert::false(VatId::isValid($vatId));
		}
	}

	public function testException(): void
	{
		Assert::exception(static function (): void {
			VatId::from('');
		}, InvalidTypeException::class);

		Assert::exception(static function (): void {
			VatId::from('sk123456789-');
		}, InvalidTypeException::class);

		Assert::exception(static function (): void {
			VatId::from('CZ1234.56789');
		}, InvalidTypeException::class);
	}

	public function testVatIdWithDifferentCountryCode(): void
	{
		$vatId = VatId::from('EL123456789');
		Assert::equal('EL123456789', $vatId->getValue());
		Assert::equal(CountryCode::GR, $vatId->getCountry()->getValue());
		Assert::equal('EL', $vatId->getPrefix());
		Assert::equal('123456789', $vatId->getVatNumber());

		$vatId = VatId::from('GY123456');
		Assert::equal('GY123456', $vatId->getValue());
		Assert::equal(CountryCode::GG, $vatId->getCountry()->getValue());
		Assert::equal('GY', $vatId->getPrefix());
		Assert::equal('123456', $vatId->getVatNumber());
	}

	/**
	 * @return string[]
	 */
	public function getValidVatIds(): array
	{
		return [
			'ATU12345678',

			'BE1234567890',
			'BE0234567890',

			'BG123456789',
			'BG1234567890',

			'HR12345678901',
			'HR12345678901',

			'CY12345678X',
			'CY12345678Y',

			'CZ12345678',
			'CZ123456789',
			'CZ1234567890',

			'DK12 34 56 78',

			'EE123456789',

			'FI12345678',

			'FRXX 123456789',
			'FRX1 123456789',
			'FR11 123456789',

			'DE123456789',

			'GR123456789',
			'EL123456789',

			'HU12345678',

			'IE1234567X',
			'IE1234567XW',

			'IT12345678901',

			'LV12345678901',

			'LT123456789',
			'LT123456789012',

			'LU12345678',

			'MT12345678',

			'NL123456789B12',

			'PL1234567890',

			'PT123456789',

			'RO1234567890',

			'SK1234567895',

			'SI12345678',

			'SE123456789012',

			'CHE123456789MWST',
			'CHE123456789TVA',
			'CHE123456789IVA',

			'GB123 4567 89',

			'GY123456',

			'ATU99999999',
			'BE0999999999',
			'BG999999999',
			'BG9999999999',
			'CY99999999L',
			'CZ99999999',
			'CZ999999999',
			'CZ9999999999',
			'DE999999999',
			'DK99 99 99 99',
			'EE999999999',
			'EL999999999',
			'ESX9999999X',
			'FI99999999',
			'FRXX 999999999',
			'GB999 9999 99',
			'GB999 9999 99 999',
			'HR99999999999',
			'HU99999999',
			'IE9999999L',
			'IE9999999WI',
			'IT99999999999',
			'LT999999999',
			'LT999999999999',
			'LU99999999',
			'LV99999999999',
			'MT99999999',
			'NL999999999B99',
			'PL9999999999',
			'PT999999999',
			'RO999999999',
			'SE999999999999',
			'SI99999999',
			'SK9999999999',
		];
	}

	/**
	 * @return string[]
	 */
	public function getInvalidVatIds(): array
	{
		return [
			'ATU123456789',
			'ATU12345678901',

			'BE2234567890',
			'BE023456789',
			'BE02345678901',

			'BG12345678',
			'BG12345678901',

			'HR1234567890',
			'HR123456789012',

			'CY123456781',
			'CY123456781X',
			'CY1234567X',

			'CZ1234567',
			'CZ12345678901',

			'DK1234567',
			'DK123456789',

			'EE12345678',
			'EE1234567890',

			'FI1234567',
			'FI123456789',

			'FRX123456789',
			'FRX123456789',
			'FR1123456789',
			'FR112345678901',

			'DE12345678',
			'DE1234567890',

			'GR12345678',
			'GR1234567890',
			'EL12345678',
			'EL1234567890',

			'HU1234567',
			'HU123456789',

			'IE123456X',
			'IE1234567',
			'IE1234567XWS',
			'IE1234567XW1',

			'IT1234567890',
			'IT123456789012',

			'LV1234567890',
			'LV123456789012',

			'LT12345678',
			'LT1234567890',
			'LT12345678901',
			'LT1234567890123',

			'LU1234567',
			'LU123456789',

			'MT1234567',
			'MT123456789',

			'NL123456789B123',
			'NL123456789B1',

			'PL123456789',
			'PL12345678901',

			'PT12345678',
			'PT1234567890',

			'RO1',
			'RO12345678901',

			'SK123456789',
			'SK12345678901',
			'SK1234567896',

			'SI1234567',
			'SI123456789',

			'SE1X12345678',
			'SE123456789',
			'SEX1234567X1',

			'CH123456789MWST',
			'CHE12345679TVA',
			'CHE123456789IVAA',

			'GB12345678',
			'GB1234567890',

			'GY12345',
			'GY1234567',

			'123456789',
		];
	}

}

(new VatIdTest())->run();
