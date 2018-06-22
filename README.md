# smartemailing \ Types 

Handy collection of PHP value objects and composite types to make data validation easier. 

Highly extendable.

🚧 Work in progress, all pull requests are welcome :-)

Data validation accross the application is tedious. Using value objects instead of neverending validation will solve this issue, making 
your code much more readable and less vulnerable to bugs.

**Types** value objects is guaranteed to be valid and normalized; or not to exist at all. In case of invalid input, **Types** will throw `InvalidTypeException`.
That means you initialize value object. From that time, you no not need any more validation.

**Types** are divided into several families:

- String-extractable types - validated strings (e-mail address, domains, hexadecimal strings,...)
- Int-extractable types - validated ints (Port) 
- Enum-extractable types - enumerables (TimeUnit, GDPR's Lawful purposes)
- Composite (Array-extractable) types - structures containing multiple another types (Address)

Different types provide different type- or family-related methods, but every type shares following common API:

#### Creation directly from value

```
<?php

	// Valid input

	$emailaddress = Emailaddress::from('hello@gmail.com') // returns Emailaddress object
	$emailaddress = Emailaddress::from($emailaddress) // returns original $emailaddress

	// Invalid input

	$emailaddress = Emailaddress::from('blabla') // throws InvalidTypeException
	$emailaddress = Emailaddress::from(1) // throws InvalidTypeException
	$emailaddress = Emailaddress::from(false) // throws InvalidTypeException
	$emailaddress = Emailaddress::from(null) // throws InvalidTypeException
	$emailaddress = Emailaddress::from([]) // throws InvalidTypeException
	$emailaddress = Emailaddress::from(new \StdClass()) // throws InvalidTypeException

	$emailaddress = Emailaddress::fromOrNull(null) // returns NULL
	$emailaddress = Emailaddress::fromOrNull('blabla') // throws InvalidTypeException
	$emailaddress = Emailaddress::fromOrNull('blabla', true) // returns NULL

```

#### Extraction from array

This is really useful for strict-typing (validation) multidimensional arrays like API requests or Forms data.

```
<?php

	$input = [

	];

	$emailaddress = Emailaddress::extract($input, 'emailaddress'); // throws InvalidTypeException
	$emailaddress = Emailaddress::extractOrNull($input, 'emailaddress'); // returns null

	$input = [
		'emailaddress' => 'blabla'
	];

	$emailaddress = Emailaddress::extract($input, 'emailaddress') //  throws InvalidTypeException
	$emailaddress = Emailaddress::extractOrNull($input, 'emailaddress') //  throws InvalidTypeException
	$emailaddress = Emailaddress::extractOrNull($input, 'emailaddress', true) // returns null

	$input = [
		'emailaddress' => 'blabla'
	];

	$emailaddress = Emailaddress::extract($emailaddress) // returns Emailaddress object

```

### String-extractable types

String-extractable types are based on validated strings. 

They can be easily converted back to string by `(string)` type casting or calling `$type->getValue()`

#### Emailaddress

Trimmed, lowercased e-mail address. 

Type-specific methods:
- `getLocalPart()` returns local part of e-mail address (part before `@`)
- `getDomain()` returns Domain type (part after `@`, represented as `Types\Domain`)



...
WORK IN PROGRESS

run tests by `vendor/bin/tester tests`
