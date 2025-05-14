# ChangeLog

All notable changes are documented in this file using the [Keep a CHANGELOG](https://keepachangelog.com/) principles.

## [2.0.0] - 2025-MM-DD

### Removed

* This library no longer supports PHP 8.3

## [1.0.4] - 2025-05-11

### Fixed

* Class `AbstractMysqliDatabaseConnection` is marked as internal

## [1.0.3] - 2024-08-09

### Fixed

* `AbstractMysqliDatabaseConnection::connect()` leaks `mysqli_sql_exception` when connecting to the database fails

## [1.0.2] - 2024-07-15

### Fixed

* Narrowed return type of `ReadingDatabaseConnection::query()` to `list<array<non-empty-string, float|int|string>>`

## [1.0.1] - 2024-07-14

### Fixed

* `ReadingDatabaseConnection::query()` now accepts parameters of type `float`, `integer`, and `string`
* `WritingDatabaseConnection::query()` now accepts parameters of type `float`, `integer`, and `string`
* `Testing::assertQuery()` now accepts parameters of type `float`, `integer`, and `string`

## [1.0.0] - 2024-07-14

* Initial release

[2.0.0]: https://github.com/sebastianbergmann/mysqli-wrapper/compare/1.0.4...main
[1.0.4]: https://github.com/sebastianbergmann/mysqli-wrapper/compare/1.0.3...1.0.4
[1.0.3]: https://github.com/sebastianbergmann/mysqli-wrapper/compare/1.0.2...1.0.3
[1.0.2]: https://github.com/sebastianbergmann/mysqli-wrapper/compare/1.0.1...1.0.2
[1.0.1]: https://github.com/sebastianbergmann/mysqli-wrapper/compare/1.0.0...1.0.1
[1.0.0]: https://github.com/sebastianbergmann/mysqli-wrapper/compare/7fcdc443b92045446dc8ba4a2ed645c0e918c867...1.0.0
