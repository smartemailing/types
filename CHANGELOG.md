# Changelog

## 6.1.0 (unreleased)

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
