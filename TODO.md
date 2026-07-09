# TODO

## Refactoring

- Rename report entry field `variation` to `variation_name`.
  - Update `Shurloc_Catalog_Report`
  - Update `Shurloc_Catalog_Analyzer`
  - Update integration tests
  - Update any future report serializers
  - Reason: distinguish a variation name (string) from a WooCommerce variation object/ID.
- Rename report methods from `add_*()` to `record_*()` to better reflect that the report records analysis results rather than managing a generic collection.
- Extract catalog report generation into a dedicated service if a second consumer emerges (WP-CLI, scheduled task, REST API, etc.).

## Reporting

- Add summary statistics to `Shurloc_Catalog_Report`.
- Add JSON serialization.
- Generate catalog report from the WordPress Tools page.

## Analysis

- Detect duplicate mesh specifications.
- Detect unexpected colors, modifiers, and pack sizes.
- Add catalog statistics (mesh counts, colors, etc.).
