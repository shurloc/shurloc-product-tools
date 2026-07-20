# Changelog

## [0.9.0] - 2026-07-20

### Added

- Added `Shurloc_Catalog_Report_Controller` to manage catalog report admin tools.
- Added `Shurloc_Catalog_Report_Request_Handler` to separate admin request
  routing from catalog report generation.
- Added catalog report action abstraction to improve testability and reduce
  coupling between WordPress request handling and report execution.
- Added integration coverage for catalog report generation using real catalog
  fixtures.
- Added integration tests covering:
  - catalog report generation
  - recognized mesh specification detection
  - unknown variation handling

### Changed

- Refactored catalog report admin tools from procedural functions into a
  controller-based architecture.
- Updated catalog report initialization to use dependency injection for
  catalog services.
- Separated admin request handling from report generation logic.
- Updated catalog report tests to use injected action doubles instead of
  directly exercising WordPress-dependent behavior.
- Improved separation between WooCommerce catalog collection, report analysis,
  and admin presentation.

### Developer Improvements

- Added request handler tests covering:
  - admin hook registration
  - ignored requests without actions
  - export request routing
  - catalog report request routing

- Added controller integration coverage to verify the complete catalog report
  workflow from catalog entries through report generation.

- Improved plugin architecture to support future admin tools without adding
  additional procedural handlers.

### Upgrade Notes

This release changes the internal architecture of catalog reporting.
No database changes or configuration updates are required.

Developers extending catalog reporting should use the controller and request
handler architecture rather than adding new procedural admin functions.

## [0.8.1] - 2026-07-20

### Fixed

- Fixed include path for autoloader in plugin bootstrap.

## [0.8.0] - 2026-07-16

### Added

- Added a recursive plugin autoloader for Shur-Loc Product Tools.
- Added automatic discovery of PHP classes, interfaces, and traits located
  anywhere within the `includes/` directory.
- Added support for interface and trait files without requiring the
  `Interface` or `Trait` suffix in the filename.

### Changed

- Updated plugin initialization to use the new autoloader instead of relying
  on manually ordered class includes.
- Simplified dependency loading by allowing new plugin classes to be added
  without modifying bootstrap include statements.
- Updated bootstrap initialization to load application services through the
  autoloader.

### Developer Improvements

- Added recursive autoloader tests covering:
  - class loading
  - interface loading
  - trait loading
  - nested include directories

- Added plugin bootstrap tests covering:
  - plugin entry point registration
  - service initialization
  - WordPress hook registration
  - frontend and admin integration loading

### Upgrade Notes

This release changes the internal loading mechanism for plugin classes.
No database changes or configuration updates are required.

Developers adding new classes should place files within the appropriate
`includes/` subdirectory and follow the existing filename conventions:

```
includes/
├── services/
│   └── class-shurloc-example-service.php
├── interfaces/
│   └── interface-shurloc-example.php
└── traits/
    └── trait-shurloc-example.php
```

The autoloader automatically discovers these files during plugin startup.

## [0.7.0] - 2026-07-16

### Added

- Added mesh-specific structured data support for WooCommerce products.
- Added product schema generation support for mesh products using `AggregateOffer` structured data.
- Added mesh variation analysis to identify valid mesh specifications from product variations.
- Added support for preserving mesh variation details including:
  - Mesh count
  - Thread diameter
  - Mesh color
  - Variation pricing
- Added product catalog service support for:
  - Product brand detection from taxonomy
  - Manufacturer metadata
  - Product availability
  - Aggregate rating and review data preparation
- Added integration coverage for generated Product schema output.
- Added comprehensive PHPUnit coverage for:
  - Product catalog generation
  - Mesh product analysis
  - Product schema generation
  - Structured data integration rendering

### Changed

- Updated `Shurloc_Catalog_Product_Entry` to support structured product metadata:
  - Brand
  - Manufacturer
  - Aggregate ratings
  - Reviews
  - Variations
- Updated product schema generation to distinguish between:
  - Mesh products requiring `AggregateOffer`
  - Standard products using `Offer`
- Updated test fixtures and test doubles to align with the expanded catalog product model.
- Improved WooCommerce compatibility in catalog data extraction by normalizing missing product metadata.

### Fixed

- Fixed structured data generation failures caused by incomplete product metadata.
- Fixed test failures related to WooCommerce product review methods not available in test doubles.
- Fixed variation fixture handling after adding support for variation-aware product schema.
- Fixed catalog entry constructor mismatches after expanding structured data fields.

### Developer Notes

- Added mesh structured data foundation for future AI search visibility improvements.
- Structured data output now better represents shur-loc® mesh products and their selectable variations.
- All PHPUnit tests pass after updates to product models, schema services, and integration tests.

## [0.6.1] - 2026-07-13

### Changed

- Refactored catalog processing to use `Shurloc_Catalog_Variation_Entry` objects.
- Updated catalog analysis to pass complete catalog variation entries through the analyzer instead of separate variation strings and metadata callbacks.
- Removed index-based metadata mapping between catalog variations and report entries.
- Added catalog variation entry serialization support for reporting and future integrations.
- Updated integration tests and catalog fixtures to use the new catalog entry data model.

### Internal Improvements

- Simplified data flow between WooCommerce catalog extraction, analysis, and reporting.
- Reduced coupling between catalog collection and report generation.
- Established a cleaner foundation for future structured product data generation and product-page presentation features.

### Testing

- Updated integration tests to validate catalog analysis using catalog variation entries.
- Verified catalog reports and variation exports continue to generate successfully.
- Confirmed linting and PHPUnit tests pass.

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
