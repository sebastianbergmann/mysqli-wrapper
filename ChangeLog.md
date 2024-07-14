# ChangeLog

All notable changes are documented in this file using the [Keep a CHANGELOG](https://keepachangelog.com/) principles.

## [1.0.1] - 2024-07-14

### Fixed

* `ReadingDatabaseConnection::query()` now accepts parameters of type `float`, `integer`, and `string`
* `MysqliReadingDatabaseConnectionTrait::query()` now accepts parameters of type `float`, `integer`, and `string`
* `WritingDatabaseConnection::query()` now accepts parameters of type `float`, `integer`, and `string`
* `Testing::assertQuery()` now accepts parameters of type `float`, `integer`, and `string`

## [1.0.0] - 2024-07-14

* Initial release

[1.0.1]: https://github.com/sebastianbergmann/mysqli-wrapper/compare/1.0.0...1.0.1
[1.0.0]: https://github.com/sebastianbergmann/mysqli-wrapper/compare/7fcdc443b92045446dc8ba4a2ed645c0e918c867...1.0.0
