# TODO

## Refactoring

- Rename report entry field `variation` to `variation_name`.
  - Update `Shurloc_Catalog_Report`
  - Update `Shurloc_Catalog_Analyzer`
  - Update integration tests
  - Update report serializers
  - Reason: distinguish a variation name (string) from a WooCommerce variation object/ID.

- Rename report methods from `add_*()` to `record_*()`.
  - Better reflects that reports record analysis results.

- Refactor mesh table renderer tests to use DOMDocument/XPath assertions
  - Replace brittle HTML string assertions in `ShurlocMeshProductTableRendererTest` and integration tests with DOM-based assertions.
  - Parse rendered table HTML using `DOMDocument`.
  - Use XPath queries to verify:
    - Required table structure exists (`table`, `caption`, `thead`, `tbody`).
    - Column headers exist by text content rather than exact HTML markup.
    - Optional columns (`Modifier`, `Pack Size`) appear or disappear correctly.
    - Column ordering is correct by inspecting the `<th>` node sequence.
    - Table rows contain expected cell values.
  - Keep CSS class assertions only where CSS hooks are part of the rendering contract, not for validating semantic content.

  - **Goal:** Make renderer tests resilient to harmless HTML changes (attributes classes, formatting) while still validating the customer-facing table structure.

## Presentation

- Build mesh specification table generator.
  - Generate normalized rows from `Shurloc_Mesh_Product_Result`.
  - Group by color.
  - Preserve WooCommerce variation ordering where appropriate.
  - Return presentation-ready DTOs rather than HTML.

- Integrate with WooCommerce product pages.
  - Inject the table into the product template.
  - Support Divi product templates.

## Structured Data

- Add integration tests confirming visible data and schema remain synchronized.

## Analysis

- Detect duplicate mesh specifications.
- Detect unexpected colors.
- Detect unexpected modifiers.
- Detect unexpected pack sizes.
- Add catalog statistics.
  - Mesh counts
  - Colors
  - Thread diameters
  - Pack sizes
  - Duplicate counts

## Reporting

- Add report version metadata.
- Add plugin version metadata.
- Add report generation timestamp.
- Add analyzer version.
- Optionally embed summary statistics in report header.

## Testing

- Add integration tests for mesh table generation.
- Add renderer snapshot tests.
- Add malformed variation fixture tests.
- Add regression tests for known historical parsing bugs.
- Expand catalog fixtures with edge cases.
- Improve asset registration tests
  - Add a WordPress-aware testing framework (WordPress test suite or Brain Monkey).
  - Replace the current asset registration test with assertions that:
    - `register()` attaches `enqueue_styles()` to `wp_enqueue_scripts`.
    - The callback is registered at priority `10`.
  - Add integration tests verifying:
    - CSS is enqueued when `[shurloc_mesh_table]` is present.
    - CSS is not enqueued when the shortcode is absent

## Build

- Add version stamping from plugin header (optional).
- Add build summary.
  - Plugin name
  - Version
  - Files
  - Directories
  - ZIP size
  - Output location

## Future

- WP-CLI catalog analysis command.
- Scheduled catalog audit.
- REST endpoint for catalog reports.
- Admin dashboard for catalog health.
