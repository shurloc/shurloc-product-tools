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
- Evaluate replacing the catalog analyzer metadata callback with a `Shurloc_Catalog_Entry` value object.
  - Encapsulate a variation and its associated metadata.
  - Eliminate parallel collections and metadata callbacks.
  - Preserve analyzer independence from WooCommerce.
  - Implement only if additional catalog metadata or consumers justify the abstraction.

## Reporting

- Generate catalog report from the WordPress Tools page.
  - Add "Generate Catalog Report" admin action.
  - Download catalog-report.json.
  - Reuse the catalog analyzer and report classes.
  - Add a reusable JSON download helper.

## Analysis

- Detect duplicate mesh specifications.
- Detect unexpected colors, modifiers, and pack sizes.
- Add catalog statistics (mesh counts, colors, etc.).

## Build

- Add version stamping from the plugin header (optional).
- Add a summary of the build: plugin name, files, directories, ZIP size, and output location.
