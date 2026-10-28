# Changelog

## 6.1.1

### Fixed

- `IntType::from()` rejects non-finite floats (`NAN`, `INF`) and floats outside the int range instead of casting them. Previously `NAN`/`INF` returned `0`, `1e30` returned a meaningless number and PHP 8.5 emitted the warning "not representable as an int". The same applies to all types built on `IntType` (`UnsignedInt`, `PositiveInt`, `Port`, `Quantity`, `IntArray`, …).
- `IntType::from((float) PHP_INT_MIN)` returns `PHP_INT_MIN` instead of throwing.
- `InvalidTypeException` messages for `NAN` no longer trigger the PHP 8.5 warning "unexpected NAN value was coerced to string".

## 6.1.0

### Added

- `InvalidTypeException::getPublicMessage()` – error message without internal details (PHP class names, PHP types), safe for public API responses. Falls back to `getMessage()`.
- `InvalidTypeException::getKey()` – path of keys where the error occurred, outer key first (e.g. `address.country` for `Address::extract($data, 'address')`).
- `InvalidTypeException::getInvalidValue()` – the invalid value for type errors and enums, otherwise null.
- `InvalidTypeException::getAcceptedValues()` – list of accepted values for enums.
- Optional constructor arguments of `InvalidTypeException` after the existing ones: `$publicMessage`, `$invalidValue`, `$acceptedValues`.

`getMessage()` output is unchanged. Use `getPublicMessage()` for API responses and `getMessage()` for logs.
Exceptions thrown by custom types (`new InvalidTypeException('...')`) keep working, their message is considered public.

## 6.0.0

### Changed (BC break)

- `Emailaddress` rejects addresses exceeding RFC 5321 length limits (local part max 64 octets, whole address max 254 octets).
