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

## Presentation

- Build mesh specification table generator.
  - Generate normalized rows from `Shurloc_Mesh_Product_Result`.
  - Group by color.
  - Preserve WooCommerce variation ordering where appropriate.
  - Return presentation-ready DTOs rather than HTML.

- Build frontend renderer.
  - Render the mesh specification table.
  - Keep HTML generation separate from data generation.

- Integrate with WooCommerce product pages.
  - Inject the table into the product template.
  - Support Divi product templates.

## Structured Data

- Generate Product schema directly from `Shurloc_Mesh_Product_Result`.
- Ensure structured data and visible table consume the same source.
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
