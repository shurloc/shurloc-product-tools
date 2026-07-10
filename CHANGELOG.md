# Changelog

## [0.6.0] - 2026-07-10

### Added

- Added `Shurloc_Catalog_Report` for collecting and serializing catalog analysis results.
- Added summary statistics to catalog reports.
- Added JSON serialization for catalog reports.
- Added a WordPress admin action to generate and download catalog reports.
- Added a reusable JSON download helper.
- Added product metadata (product ID, product name, and edit URL) to report entries.
- Added `shurloc_get_catalog_entries()` as the canonical WooCommerce catalog source.

### Changed

- Refactored the catalog analyzer to return a `Shurloc_Catalog_Report` instead of raw arrays.
- Refactored the catalog analyzer to support optional metadata providers while remaining independent of WordPress.
- Refactored variation export to use the shared catalog entry provider.

## [0.5.1] - 2026-07-10

### Added

- Added `LICENSE` to release packages.
- Added `README.md` to release packages.

## [0.5.0] - 2026-07-09

### Added

- Added `Shurloc_Catalog_Report` for recording catalog analysis results.
- Added `Shurloc_Catalog_Analyzer` to analyze exported WooCommerce catalog variations.
- Added report summary statistics.
- Added JSON serialization for catalog reports.
- Added `Shurloc_Mesh_Specification::to_array()`.
- Added integration tests for catalog analysis and reporting.
- Added behavioral invariant tests for report generation.
- Added PowerShell build script for creating distributable plugin packages.

### Changed

- Refactored catalog analysis to return a `Shurloc_Catalog_Report` instance instead of a raw array.
- Improved integration test coverage for catalog recognition and reporting.

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
