# SmartEmailing \ Types 

### Missing data types for PHP 7.1. Highly extendable.

[![Monthly Downloads](https://poser.pugx.org/smartemailing/types/d/monthly)](https://packagist.org/packages/smartemailing/types)
[![codecov](https://codecov.io/gh/smartemailing/types/branch/master/graph/badge.svg)](https://codecov.io/gh/smartemailing/types)
[![CircleCI](https://circleci.com/gh/smartemailing/types.svg?style=shield)](https://circleci.com/gh/smartemailing/types)
[![license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/smartemailing/types/blob/master/LICENSE)

🚧 Work in progress, all pull requests are welcome :-)

##

Neverending data validation is tedious. Replacing it with **Types** will make 
your code much more readable and less vulnerable to bugs.

**Types** provide value objects that are guaranteed to be **valid and normalized; or not to exist at all**. 

How does it work? You just initialize particular value object by simple one-liner. 
From this point, you have sanitized, normalized and valid data; or an exception to handle.

**Types** consist from:

- String-extractable types - validated strings (E-mail address, Domains, Hexadecimal strings,...)
- Int-extractable types - validated integers (Port) 
- Float-extractable types - validated floats (Part) 
- Enum-extractable types - enumerables (Country, Currency, GDPR's Lawful purpose, ...)
- Composite (Array-extractable) types - structures containing multiple another types (Address, ...)
- Primitive types extractors and arrays

Different types provide different methods related to them, but all types share this extraction API:

## Wrapping raw value

```php
<?php

declare(strict_types = 1);

use SmartEmailing\Types\Emailaddress;
use SmartEmailing\Types\InvalidTypeException;

// Valid input

$emailaddress = Emailaddress::from('hello@gmail.com'); // returns Emailaddress object
$emailaddress = Emailaddress::from($emailaddress); // returns original $emailaddress

// Invalid input

$emailaddress = Emailaddress::from('bla bla'); // throws InvalidTypeException
$emailaddress = Emailaddress::from(1); // throws InvalidTypeException
$emailaddress = Emailaddress::from(false); // throws InvalidTypeException
$emailaddress = Emailaddress::from(null); // throws InvalidTypeException
$emailaddress = Emailaddress::from([]); // throws InvalidTypeException
$emailaddress = Emailaddress::from(new \StdClass()); // throws InvalidTypeException

// Nullables

$emailaddress = Emailaddress::fromOrNull(null); // returns NULL
$emailaddress = Emailaddress::fromOrNull('bla bla'); // throws InvalidTypeException
$emailaddress = Emailaddress::fromOrNull('bla bla', true); // returns null instead of throwing

```

## Extraction from array

This is really useful for strict-typing (validation) multidimensional arrays like API requests or forms data.

```php
<?php

use SmartEmailing\Types\Emailaddress;
use SmartEmailing\Types\InvalidTypeException;

$input = [
	'emailaddress' => 'hello@gmail.com',
	'already_types_emailaddress' => Emailaddress::from('hello2@gmail.com'),
	'invalid_data' => 'bla bla',
];

// Valid input

$emailaddress = Emailaddress::extract($input, 'emailaddress'); // returns Emailaddress object
$emailaddress = Emailaddress::extract($input, 'already_types_emailaddress'); // returns original Emailaddress object

// Invalid input

$emailaddress = Emailaddress::extract($input, 'invalid_data'); // throws InvalidTypeException
$emailaddress = Emailaddress::extract($input, 'not_existing_key'); // throws InvalidTypeException

// Nullables 

$emailaddress = Emailaddress::extractOrNull($input, 'not_existing_key'); // returns null
$emailaddress = Emailaddress::extractOrNull($input, 'invalid_data'); //  throws InvalidTypeException
$emailaddress = Emailaddress::extractOrNull($input, 'invalid_data', true); // returns null instead of throwing

// Default values
$emailaddress 
	= Emailaddress::extractOrNull($input, 'not_existing_key') 
	?? Emailaddress::from('default@domain.com'); 
	// uses null coalescing operator to assign default value if key not present or null

$emailaddress 
	= Emailaddress::extractOrNull($input, 'not_existing_key', true) 
	?? Emailaddress::from('default@domain.com'); 
	// uses null coalescing operator to assign default value if key not present or null or invalid


```

## String-extractable types

String-extractable types are based on validated strings. All values are trimmed before validation.

They can be easily converted back to string by string-type casting or calling `$type->getValue()`.

### E-mail address

`SmartEmailing\Types\Emailaddress`

Lowercased and ASCII-transformed e-mail address (`hello@gmail.com`)

Type-specific methods:
- `getLocalPart() : string` returns local part of e-mail address (`hello`)
- `getDomain() : \SmartEmailing\Types\Domain` returns domain part (`gmail.com`, represented as `Types\Domain`)

### Domain

`SmartEmailing\Types\Domain`

Lowercased domain name (`mx1.googlemx.google.com`)

Type-specific methods:
- `getSecondLevelDomain() : \SmartEmailing\Types\Domain` returns second-level domain. (`google.com`)


### Hex 32

`SmartEmailing\Types\Hex32`

Lowercased 32-characters long hexadecimal string useful as container for MD5 or UUID without dashes. (`741ecf779c9244358e6b85975bd13452`)


### GUID

`SmartEmailing\Types\Guid`

Lowercased Guid with dashes (`741ecf77-9c92-4435-8e6b-85975bd13452`)

### IP address

`SmartEmailing\Types\IpAddress`

IP address v4 or v6. (`127.0.0.1`, `[2001:0db8:0a0b:12f0:0000:0000:0000:0001]`, `2001:db8:a0b:12f0::1`)

Type-specific methods:
- `getVersion() : int` returns IP address version, `4` or `6`

### URL

`SmartEmailing\Types\UrlType`

URL based on `Nette\Http\Url` (`https://www.google.com/search?q=all+work+and+no+play+makes+jack+a+dull+boy`)

Type-specific methods:
- `getAuthority() : string` returns authority (`www.google.com`)
- `getHost() : string` returns Host (`www.google.com`)
- `getQueryString() : string` returns Query string (`q=all%20work%20and%20no%20play%20makes%20jack%20a%20dull%20boy`)
- `getPath() : string` returns URl Path (`/search`)
- `getAbsoluteUrl() : string` Complete URL as `string`, alias for `getValue()` 
- `getQueryParameter(string $name, mixed $default = null): mixed` Return value of parameter `$name`
- `getBaseUrl(): string` Return URL without path, query string and hash part (`https://www.google.cz/`)
- `getScheme(): string` Return URL scheme (`https`)
- `hasParameters(string[] $names): bool` Returns `true` if URL parameters contain all parameters defined in `$names` array
- `getParameters(): array` Returns all URL parameters as string-indexed array
- `withQueryParameter(string $name, mixed $value): UrlType` Returns new instance with added query parameter.

### Company registration number

`SmartEmailing\Types\CompanyRegistrationNumber`

Whitespace-free company registration number for following countries: 
`CZ`, `SK`, `DE`, `CY`

### Phone number

`SmartEmailing\Types\PhoneNumber`

Whitespace-free phone number in international format for following countries: 
`CZ`, `SK`, `AT`, `BE`, `FR`, `HU`, `GB`, `DE`, `US`, `PL`, `IT`, `SE`, `SI`, `MH`, `NL`, `CY`, `IE`, `DK`, `FI`, `LU`

Type-specific methods:
- `getCountry() : SmartEmailing\Types\Country` Originating country (`CZ`)


### ZIP code

`SmartEmailing\Types\ZipCode`

Whitespace-free ZIP code valid in following countries: 
`CZ`, `SK`, `UK`, `US`


### JSON

`SmartEmailing\Types\JsonString`

Valid JSON-encoded data as string

Type-specific methods:
- `static encode(mixed $data) : SmartEmailing\Types\JsonString` create JsonString from raw data
- `getDecodedValue() : mixed` decode JsonString back to raw data

### Base 64

`SmartEmailing\Types\Base64String`

Valid Base 64-encoded data as string

Type-specific methods:
- `static encode(string $value) : SmartEmailing\Types\Base64String` create Base64String from string
- `getDecodedValue() : string` decode Base64String back to original string


### Iban

`SmartEmailing\Types\Iban`

Type-specific methods:
- `getFormatted(): string` returns whitespace Iban
- `getCountry(): SmartEmailing\Types\Country`
- `getChecksum(): int` 
- `getAccountIdentification(): string`
- `getInstituteIdentification(): string`
- `getBankAccountNumber(): string`

### SwiftBic

`SmartEmailing\Types\SwiftBic`

Valid Swift/Bic codes.

### VatId
`SmartEmailing\Types\VatId`

Type-specific methods:
- `static isValid(string $vatId): bool` returns true if the vat id is valid otherwise returns false
- `getCountry(): ?Country` returns `Country` under which the subject should falls or null.
- `getPrefix(): ?string` returns string that prefixing vat id like `EL` from `EL123456789` or null.
- `getVatNumber(): string` returns vat number without prefix like `123456789`
- `getValue(): string` return whole vat id `EL123456789`


## Int-extractable types

Int-extractable types are based on validated integers.

They can be easily converted back to int by int-type casting or calling `$type->getValue()`.

### Port

`SmartEmailing\Types\Port`

Port number

Integer interval, `<0, 65535>`

## Float-extractable types

Float-extractable types are based on validated floats.

They can be easily converted back to float by float-type casting or calling `$type->getValue()`.

### Part

`SmartEmailing\Types\Part`

Portion of the whole

Float interval `<0.0, 1.0>`

Type-specific methods:
- `static fromRatio(float $value, float $whole): Part` creates new instance by division `$value` and `$whole`.
-  `getPercent(): float` returns `(Ratio's value) * 100` to get percent representation

### Sigmoid function value

`SmartEmailing\Types\SigmoidValue`

Result of Sigmoid function, useful when building neural networks.

Float interval `<-1.0, 1.0>`. 

### Rectified Linear Unit function value

`SmartEmailing\Types\ReLUValue`

Result of Rectified Linear Unit function function, useful when building neural networks.

Float interval `<0.0, Infninity)`. 

🚧 Documentation still under construction, to be continued :-) 🚧 


#

run tests by `vendor/bin/tester tests`
