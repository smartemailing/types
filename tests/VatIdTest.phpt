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
		Assert::type(Country::class, $vatId->getCountry());
		Assert::equal(Country::CZ, $vatId->getCountry()->getValue());
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
		Assert::equal(Country::GR, $vatId->getCountry()->getValue());
		Assert::equal('EL', $vatId->getPrefix());
		Assert::equal('123456789', $vatId->getVatNumber());

		$vatId = VatId::from('GY123456');
		Assert::equal('GY123456', $vatId->getValue());
		Assert::equal(Country::GG, $vatId->getCountry()->getValue());
		Assert::equal('GY', $vatId->getPrefix());
		Assert::equal('123456', $vatId->getVatNumber());
	}

	/**
	 * @return string[]
	 */
	public function getValidVatIds(): array
	{
		return [
			Country::AT . 'U12345678',

			Country::BE . '1234567890',
			Country::BE . '0234567890',

			Country::BG . '123456789',
			Country::BG . '1234567890',

			Country::HR . '12345678901',
			Country::HR . '12345678901',

			Country::CY . '12345678X',
			Country::CY . '12345678Y',

			Country::CZ . '12345678',
			Country::CZ . '123456789',
			Country::CZ . '1234567890',

			Country::DK . '12 34 56 78',

			Country::EE . '123456789',

			Country::FI . '12345678',

			Country::FR . 'XX 123456789',
			Country::FR . 'X1 123456789',
			Country::FR . '11 123456789',

			Country::DE . '123456789',

			Country::GR . '123456789',
			'EL123456789',

			Country::HU . '12345678',

			Country::IE . '1234567X',
			Country::IE . '1234567XW',

			Country::IT . '12345678901',

			Country::LV . '12345678901',

			Country::LT . '123456789',
			Country::LT . '123456789012',

			Country::LU . '12345678',

			Country::MT . '12345678',

			Country::NL . '123456789B12',

			Country::PL . '1234567890',

			Country::PT . '123456789',

			Country::RO . '1234567890',

			Country::SK . '1234567895',

			Country::SI . '12345678',

			Country::SE . '123456789012',

			Country::CH . 'E123456789MWST',
			Country::CH . 'E123456789TVA',
			Country::CH . 'E123456789IVA',

			Country::GB . '123 4567 89',

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
			Country::AT . 'U123456789',
			Country::AT . 'U12345678901',

			Country::BE . '2234567890',
			Country::BE . '023456789',
			Country::BE . '02345678901',

			Country::BG . '12345678',
			Country::BG . '12345678901',

			Country::HR . '1234567890',
			Country::HR . '123456789012',

			Country::CY . '123456781',
			Country::CY . '123456781X',
			Country::CY . '1234567X',

			Country::CZ . '1234567',
			Country::CZ . '12345678901',

			Country::DK . '1234567',
			Country::DK . '123456789',

			Country::EE . '12345678',
			Country::EE . '1234567890',

			Country::FI . '1234567',
			Country::FI . '123456789',

			Country::FR . 'X123456789',
			Country::FR . 'X123456789',
			Country::FR . '1123456789',
			Country::FR . '112345678901',

			Country::DE . '12345678',
			Country::DE . '1234567890',

			Country::GR . '12345678',
			Country::GR . '1234567890',
			'EL12345678',
			'EL1234567890',

			Country::HU . '1234567',
			Country::HU . '123456789',

			Country::IE . '123456X',
			Country::IE . '1234567',
			Country::IE . '1234567XWS',
			Country::IE . '1234567XW1',

			Country::IT . '1234567890',
			Country::IT . '123456789012',

			Country::LV . '1234567890',
			Country::LV . '123456789012',

			Country::LT . '12345678',
			Country::LT . '1234567890',
			Country::LT . '12345678901',
			Country::LT . '1234567890123',

			Country::LU . '1234567',
			Country::LU . '123456789',

			Country::MT . '1234567',
			Country::MT . '123456789',

			Country::NL . '123456789B123',
			Country::NL . '123456789B1',

			Country::PL . '123456789',
			Country::PL . '12345678901',

			Country::PT . '12345678',
			Country::PT . '1234567890',

			Country::RO . '1',
			Country::RO . '12345678901',

			Country::SK . '123456789',
			Country::SK . '12345678901',
			Country::SK . '1234567896',

			Country::SI . '1234567',
			Country::SI . '123456789',

			Country::SE . '1X12345678',
			Country::SE . '123456789',
			Country::SE . 'X1234567X1',

			Country::CH . '123456789MWST',
			Country::CH . 'E12345679TVA',
			Country::CH . 'E123456789IVAA',

			Country::GB . '12345678',
			Country::GB . '1234567890',

			'GY12345',
			'GY1234567',

			'123456789',
		];
	}

}

(new VatIdTest())->run();
