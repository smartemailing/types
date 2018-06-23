# SmartEmailing \ Types 

### Missing data types for PHP. Highly extendable.

🚧 Work in progress, all pull requests are welcome :-)

##

Data validation accross the application is tedious. Replacing it with **Types** will make 
your code much more readable and less vulnerable to bugs.

**Types** provide value objects that are guaranteed to be **valid and normalized; or not to exist at all**. 

How does it work? Simply! 
You just initialize particular value object by one line of code. 
From this point, you have sanitized, normalized and valid data; or an exception to catch.

**Types** are divided into several families:

- String-extractable types - validated strings (e-mail address, domains, hexadecimal strings,...)
- Int-extractable types - validated integerss (Port) 
- Enum-extractable types - enumerables (Country, Currency, GDPR's Lawful purpose, ...)
- Composite (Array-extractable) types - structures containing multiple another types (Address, ...)

Different families and their types provide different methods related to them, but every type shares following common API:

## Wrapping raw value

```php
<?php

	use SmartEmailing\Types\Emailaddress;

	// Valid input

	$emailaddress = Emailaddress::from('hello@gmail.com'); // returns Emailaddress object
	$emailaddress = Emailaddress::from($emailaddress); // returns original $emailaddress

	// Invalid input

	$emailaddress = Emailaddress::from('blabla'); // throws InvalidTypeException
	$emailaddress = Emailaddress::from(1); // throws InvalidTypeException
	$emailaddress = Emailaddress::from(false); // throws InvalidTypeException
	$emailaddress = Emailaddress::from(null); // throws InvalidTypeException
	$emailaddress = Emailaddress::from([]); // throws InvalidTypeException
	$emailaddress = Emailaddress::from(new \StdClass()); // throws InvalidTypeException

	// Nullables

	$emailaddress = Emailaddress::fromOrNull(null); // returns NULL
	$emailaddress = Emailaddress::fromOrNull('blabla', true); // returns null instead of throwing
	$emailaddress = Emailaddress::fromOrNull('blabla'); // throws InvalidTypeException

```

## Extraction from array

This is really useful for strict-typing (validation) multidimensional arrays like API requests or forms data.

```php

<?php

	use SmartEmailing\Types\Emailaddress;

	$input = [
		'emailaddress' => 'hello@gmail.com',
		'already_types_emailaddress' => Emailaddress::from('hello2@gmail.com'),
		'invalid_data' => 'bla bla bla',
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

```

## String-extractable types

String-extractable types are based on validated strings. All values are trimmed before validation.

They can be easily converted back to string by `(string)` type casting or calling `$type->getValue()`

### Emailaddress

Lowercased e-mail address (`hell@gmail.com`)

Type-specific methods:
- `getLocalPart() : string` returns local part of e-mail address (`hello`)
- `getDomain() : \SmartEmailing\Types\Domain` returns Domain type (`gmail.com`, represented as `Types\Domain`)

### Domain

Lowercased domain name (`mx1.googlemx.google.com`)

Type-specific methods:
- `getSecondLevelDomain() : \SmartEmailing\Types\Domain` returns derived second-level Domain. (`google.com`)


### Hex32

Lowercased 32-characters long hexadecimal string useful as container for MD5 or UUID without dashes. (`741ecf779c9244358e6b85975bd13452`)


### Guid

Lowercased Guid with dashes (`741ecf77-9c92-4435-8e6b-85975bd13452`)

### IPAddress

IP address v4 or v6. (`127.0.0.1`, `[2001:0db8:0a0b:12f0:0000:0000:0000:0001]`, `2001:db8:a0b:12f0::1`)

Type-specific methods:
- `getVersion() : int` returns IP address version, `4` or `6`



🚧 TO BE CONTINUED 🚧 


run tests by `vendor/bin/tester tests`
