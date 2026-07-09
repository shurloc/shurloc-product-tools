# Changelog

## [0.4.0] - 2026-07-09

### Added
- Mesh recognition support
- Catalog fixture loader for exported WooCommerce variations
- Catalog analyzer for classifying recognized, unrecognized, and invalid mesh specifications
- Integration tests using a real catalog snapshot

### Changed
- Refactored parser into reusable extraction methods
- Added recognition state to parsed mesh specifications
- Improved parser normalization and validation
- Refactored catalog fixture handling to separate fixture loading from PHPUnit data providers

## [0.3.0] - 2026-07-08

### Added
- Mesh specification parser
- Mesh specification model
- Unit testing infrastructure with PHPUnit
- Parser data provider for reusable test cases

### Changed
- Refactored parser into helper methods for normalization and token extraction
- Added parser normalization for whitespace, modifiers, and Thin Thread variants
- Expanded parser support for pack sizes, modifiers, colors, and price formats

## [0.2.0] - 2026-07-07

### Added
- Mesh specification model
- Mesh parser framework
- PHPUnit test infrastructure
- Initial parser unit tests
- Composer scripts for linting and testing

### Changed
- Upgraded project to PHP 8.4
- Added PHPCS and PHPUnit project configuration
- Improved project structure for future parser development

## [0.1.0] - 2026-07-06

### Added
- Initial plugin skeleton
- Bootstrap architecture
- Project structure
- WordPress Coding Standards configuration
