# Changelog

## [0.12.2] - 2026-07-24

### Changed

- Removed offers nested under aggregateOffer in product schema.

## [0.12.1] - 2026-07-23

### Added

- Added `Shurloc_Mesh_Product_Table_Assets` to register frontend assets for the mesh product table.

### Changed

- Refactored mesh table asset loading to register styles globally and enqueue them only when the mesh table shortcode renders.
- Removed shortcode detection from asset loading, improving compatibility with Divi Theme Builder and dynamically rendered content.
- Updated WordPress test doubles to distinguish between registered and enqueued styles.
- Expanded PHPUnit coverage for frontend asset registration.

## [0.12.0] - 2026-07-22

### Added

- Added `Shurloc_Mesh_Product_Table_Assets` to automatically register frontend assets for the mesh product table.
- Added automatic stylesheet loading for pages containing the `[shurloc_mesh_table]` shortcode.
- Added PHPUnit coverage for frontend asset registration and conditional stylesheet loading.
- Added WordPress test doubles for frontend asset management including:
  - `is_singular()`
  - `has_shortcode()`
  - `wp_enqueue_style()`
  - `wp_style_is()`

### Changed

- Updated plugin bootstrap to initialize mesh product table asset registration.
- Refined frontend loading so mesh table styles are only loaded when required.
- Expanded the WordPress testing framework to support frontend asset and shortcode behavior.

### Internal Improvements

- Separated frontend asset management from shortcode rendering responsibilities.
- Improved plugin architecture by introducing a dedicated asset loader for presentation resources.
- Extended the testing infrastructure with reusable WordPress frontend function stubs and enqueue tracking.

### Testing

- Added PHPUnit tests covering:
  - Asset hook registration
  - Conditional stylesheet loading
  - Shortcode detection behavior
  - Stylesheet enqueue behavior
- Verified all PHPUnit and PHPCS checks pass.

## [0.11.2] - 2026-07-22

### Added

- Added product description support to the product catalog service.
- Added product SKU support to Product schema output.
- Added product category extraction to catalog entries.
- Added schema output for product descriptions when available.
- Added test coverage for SKU and description structured data output.
- Added additional WooCommerce product test double support for:
  - Short descriptions
  - Full descriptions
  - Product metadata used by catalog generation

### Changed

- Updated the product catalog service to collect additional product-level data required for structured data generation.
- Updated Product schema generation to include SKU and description fields for simple and variable products.
- Updated schema generation to omit empty optional fields instead of emitting invalid or empty schema values.
- Improved product catalog and schema generation test coverage.
- Kept product catalog services focused on data transformation rather than unnecessary WordPress dependencies.

### Fixed

- Fixed missing description data in generated Product schema.
- Fixed missing SKU output for simple products.
- Fixed test failures caused by incomplete WooCommerce product test doubles.
- Fixed schema output consistency between simple products and variable products.

### Tests

- Added and updated PHPUnit coverage for:
  - Product catalog entry generation
  - Product descriptions
  - SKU output
  - Product brand handling
  - Variable product schema behavior
  - WooCommerce product test doubles

## [0.11.1] - 2026-07-21

### Changed
- Refactored `Shurloc_Mesh_Specification` into an immutable domain model using private readonly properties.
- Updated mesh analyzers, schema generators, renderers, services, and test fixtures to use constructor-based specification creation.
- Improved encapsulation by removing direct property mutation of mesh specification objects.
- Updated mesh product handling to consistently use accessor methods and validated specification state.
- Expanded and updated test coverage to support the new mesh specification architecture.

## [0.11.0] - 2026-07-21

### Added

- Added `Shurloc_Mesh_Product_Table_Renderer` to generate customer-facing
  mesh specification tables from analyzed product data.
- Added `Shurloc_Mesh_Product_Table_Renderer_Interface` to define frontend
  table rendering behavior.
- Added `[shurloc_mesh_table]` shortcode for displaying mesh product tables
  on WooCommerce product pages.
- Added shortcode integration with:
  - `Shurloc_Mesh_Product_Data_Service`
  - `Shurloc_Mesh_Product_Table_Renderer`
- Added PHPUnit test doubles for:
  - Mesh product data service
  - Mesh product table renderer
- Added comprehensive shortcode and integration tests covering:
  - Shortcode registration
  - Empty output for products without mesh variations
  - Rendering recognized mesh variations
  - Rendering multiple mesh variation rows

### Changed

- Updated plugin bootstrap to initialize mesh product table dependencies.
- Connected frontend presentation to the existing mesh product analysis
  pipeline without introducing WooCommerce dependencies into rendering
  classes.
- Extended test infrastructure to support shortcode and frontend rendering
  workflows.

### Internal Improvements

- Established the first presentation layer consuming mesh analysis results.
- Maintained separation between:
  - WooCommerce catalog extraction
  - Mesh product analysis
  - Customer-facing HTML rendering
- Improved dependency injection throughout the mesh product workflow,
  allowing rendering behavior to be tested independently from WordPress
  and WooCommerce runtime behavior.
- Expanded integration coverage from service-level analysis into complete
  product data-to-output rendering flow.

### Testing

- Added unit tests for `Shurloc_Mesh_Product_Table_Renderer`.
- Added unit tests for `Shurloc_Mesh_Product_Table_Shortcode`.
- Added integration tests verifying the complete mesh product table flow.
- Verified all PHPUnit and PHPCS checks pass.

## [0.10.0] - 2026-07-20

### Added

- Added `Shurloc_Mesh_Product_Data_Service` to provide a reusable service
  for retrieving analyzed mesh product data.
- Added service interfaces for:
  - `Shurloc_Product_Catalog_Service_Interface`
  - `Shurloc_Mesh_Product_Analyzer_Interface`
- Added PHPUnit test doubles for:
  - Product catalog service
  - Mesh product analyzer
- Added comprehensive unit tests covering mesh product data retrieval.
- Added behavioral tests verifying:
  - Catalog variations are passed to the analyzer
  - Mesh product detection
  - Analysis results are returned unchanged

### Changed

- Refactored `Shurloc_Product_Catalog_Service` to implement
  `Shurloc_Product_Catalog_Service_Interface`.
- Refactored `Shurloc_Mesh_Product_Analyzer` to implement
  `Shurloc_Mesh_Product_Analyzer_Interface`.
- Updated `Shurloc_Mesh_Product_Result` to encapsulate variation collections
  behind accessor methods.
- Reduced public mutable state within mesh analysis results in preparation
  for future presentation services.

### Internal Improvements

- Established a dedicated service layer between WooCommerce catalog
  extraction and frontend presentation.
- Improved dependency inversion throughout the mesh analysis pipeline,
  allowing services to be tested without concrete WooCommerce
  implementations.
- Expanded the plugin's test infrastructure with reusable service doubles
  following the existing testing conventions.

### Testing

- Added unit tests for `Shurloc_Mesh_Product_Data_Service`.
- Added unit tests for `Shurloc_Mesh_Product_Result`.
- Added analyzer interaction tests verifying catalog variation flow.
- Verified all PHPUnit and PHPCS checks pass.

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
