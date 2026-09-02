# Product Tools to Site Tools Migration Status

## Scope and Authority

- The current `shurloc-product-tools` working tree is the authoritative
  migration source. It is expected to match the `v1.6.0` tag except for
  migration documentation added during this work.
- The destination is the current `shurloc-site-tools` working tree.
- Product Tools is read-only for migration code. The only approved source-tree
  changes are this status document and updates to `MIGRATION.md`.
- The task is code consolidation only. Staging verification and release work
  are outside the assignment and will be performed manually after migration.

## Instructions and Working Rules

- Move Product Tools functionality into the Site Tools `Product` domain.
- Drop the `Shurloc_` prefix from migrated class and interface names; Site
  Tools namespaces provide the ownership context.
- Preserve source behavior. Do not add safeguards, coexistence handling,
  refactors, or unrelated improvements.
- Review persisted identifiers case by case; a separate up-front inventory is
  not required.
- Ask before adding `declare( strict_types=1 );` to a file that does not
  already have it.
- Migration normally proceeds one filesystem file per review. Tests are
  separate review files. Explicitly approved grouped review units are the
  exception.
- Always provide a source-to-destination diff after a migrated file is changed.
- Omit PHPStan for the current migration passes.
- Run PHPUnit only when migrating a test file.
- If initial checks reveal an issue, report it rather than correcting it.
- If a dependency must be migrated first, stop and report that dependency.
- Before checks, ensure each migrated file has exactly one trailing newline.
- Bootstrap wiring is a separate review unless explicitly approved together
  with the relevant double.

## Structural Decisions

- Product classes use the `Shurloc\SiteTools\Product` namespace hierarchy.
- Existing Product subdivisions are retained: analyzers, dto, factories,
  generators, integrations, models, parsers, renderers, reports, services,
  and shortcodes.
- The Product admin area is placed in
  `includes/product/admin/` with namespace
  `Shurloc\SiteTools\Product\Admin`.
- Existing Site Tools shared contracts are reused rather than duplicated. For
  example, admin page doubles use
  `Shurloc\SiteTools\Shared\Interfaces\Admin_Page_Interface`.
- Test doubles follow the namespace of the production contract they implement.
  WordPress and WooCommerce doubles remain global where their external class
  names require it.
- Product assets are located under `assets/product/css/` and
  `assets/product/js/`.
- The Product test doubles were wired into `tests/bootstrap.php` only after
  their required production interfaces and models were migrated.

## Migration Work Completed

### Product production code

The following Product production classes and interfaces have been migrated:

- Models: `Mesh_Specification`, `Catalog_Variation_Entry`,
  `Catalog_Product_Entry`, and `Mesh_Product_Result`.
- Parser: `Mesh_Parser`.
- Analyzers: `Mesh_Product_Analyzer_Interface`, `Mesh_Product_Analyzer`, and
  `Catalog_Analyzer`.
- Report: `Catalog_Report`.
- Services: `Catalog_Analysis_Service_Interface`,
  `Catalog_Analysis_Service`, `Product_Catalog_Service_Interface`,
  `Product_Catalog_Service`, `Mesh_Product_Data_Service_Interface`,
  `Mesh_Product_Data_Service`, `Product_Schema_Service_Interface`,
  `Product_Schema_Service`, `Mesh_Product_Schema_Service_Interface`, and
  `Mesh_Product_Schema_Service`.
- DTOs: `Mesh_Table_Row` and `Mesh_Table_Data`.
- Factory: `Mesh_Table_Data_Factory`.
- Renderers: `Mesh_Product_Table_Renderer_Interface`,
  `Mesh_Product_Table_Renderer`, `Product_Schema_Renderer_Interface`, and
  `Product_Schema_Renderer`.
- Shortcodes: `Mesh_Product_Table_Shortcode_Interface` and
  `Mesh_Product_Table_Shortcode`.
- Integrations: `Mesh_Product_Table_Assets` and `Mesh_Product_Table_Tab`.
- Generator: `Product_Schema_Generator`.
- Product admin: `Catalog_Report_Actions_Interface` and
  `Catalog_Report_Request_Handler`, `Catalog_Report_Controller`, and
  `Admin_Menu`.

### Tests, fixtures, and test support

The following test files and supporting Product test files have been migrated:

- Model tests: `MeshSpecificationTest`, `CatalogVariationEntryTest`,
  `CatalogProductEntryTest`, and `MeshProductResultTest`.
- Parser support/tests: `MeshParserDataProvider` and `MeshParserTest`.
- Analyzer tests: `MeshProductAnalyzerTest` and `CatalogAnalyzerTest`.
- Report test: `CatalogReportTest`.
- Service tests: `CatalogAnalysisServiceTest`, `ProductCatalogServiceTest`,
  `MeshProductDataServiceTest`, `MeshProductSchemaServiceTest`, and
  `ProductSchemaServiceTest`.
- Product admin tests: `CatalogReportRequestHandlerTest` and
  `CatalogReportControllerTest`, and `AdminMenuTest`.
- DTO tests: `MeshTableRowTest` and `MeshTableDataTest`.
- Factory test: `MeshTableDataFactoryTest`.
- Renderer tests: `MeshProductTableRendererTest` and
  `ProductSchemaRendererTest`.
- Shortcode test: `MeshProductTableShortcodeTest`.
- Integration tests: `MeshProductTableTabIntegrationTest` and
  `MeshProductTableAssetsTest`.
- Generator test: `ProductSchemaGeneratorTest`.

Migrated test doubles and shared support include:

- `Product_Catalog_Service_Double`.
- `Mesh_Product_Analyzer_Double`.
- `Mesh_Product_Data_Service_Double`.
- `Mesh_Product_Table_Renderer_Double`.
- `Mesh_Product_Table_Shortcode_Double`.
- `Catalog_Report_Actions_Double`.
- `Catalog_Report_Controller_Double`.
- `Mesh_Product_Schema_Service_Double`.
- `Product_Schema_Renderer_Double`.
- `Product_Schema_Service_Double`.
- WooCommerce doubles: `WC_Product`, `WC_Product_Variation`,
  `Test_WC_Product`, `Test_WC_Product_Variation`, and `Test_WC_Cart`.
- WordPress double: `WP_Screen`.
- Product additions to the WordPress and WooCommerce function stubs.
- Product double registrations in `tests/bootstrap.php`.

### Assets

- `assets/product/css/shurloc-mesh-product-table.css`.
- `assets/product/js/shurloc-mesh-product-table.js`.

## Verification Performed

- Migrated production files and support files were checked with PHP syntax,
  PHPCS, `git diff --check`, and final-newline validation unless an initial
  issue prevented continuing.
- Migrated tests with clean initial checks were run with focused PHPUnit.
- `ProductSchemaServiceTest` most recently passed its focused run with
  7 tests and 31 assertions.
- PHPStan has intentionally been omitted from these migration passes.

## Known Review Items and Unresolved Check Results

- JavaScript syntax validation for
  `assets/product/js/shurloc-mesh-product-table.js` could not run because
  `node` was unavailable on the command path. The asset was not changed to
  address that environment limitation.

## Immediate Dependency History

- The two catalog-report test doubles were initially deferred because they
  implement `Catalog_Report_Actions_Interface`.
- After `Catalog_Report_Actions_Interface` was migrated to the Product admin
  namespace, all remaining test doubles were migrated as one explicitly
  approved review unit.
- Those doubles were then wired into the Site Tools test bootstrap in a
  separate review file.
- `Catalog_Report_Request_Handler` was migrated next because
  `Catalog_Report_Controller` constructs it directly.
- `Catalog_Report_Controller` was migrated after its request-handler
  dependency was available.
- `CatalogReportRequestHandlerTest` was migrated after the handler. Its
  duplicate PHPUnit import was corrected during review, and its checks passed.
- `CatalogReportControllerTest` was migrated after the controller and passed
  its focused PHPUnit checks.
- `Admin_Menu` was migrated next because its only dependency is the existing
  shared `Admin_Page_Interface`; its legacy menu slug remains unchanged.
- `AdminMenuTest` was migrated after the admin menu. Its WordPress-global
  PHPCS findings were corrected during review, and its checks passed.

## Remaining Work

Significant Product areas still pending migration include the Product admin
controllers/pages/request handling, frontend integrations, product
migrations, recommendation and primary-category services, their tests, the
Product domain bootstrap, root bootstrap registration, and the final
mechanical migration audit.

This document records status only; it does not change the migration rules in
`MIGRATION.md`.
