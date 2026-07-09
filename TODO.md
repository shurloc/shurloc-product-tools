# TODO

## Refactoring

- Rename report entry field `variation` to `variation_name`.
  - Update `Shurloc_Catalog_Report`
  - Update `Shurloc_Catalog_Analyzer`
  - Update integration tests
  - Update any future report serializers
  - Reason: distinguish a variation name (string) from a WooCommerce variation object/ID.

## Reporting

- Add summary statistics to `Shurloc_Catalog_Report`.
- Add JSON serialization.
- Generate catalog report from the WordPress Tools page.

## Analysis

- Detect duplicate mesh specifications.
- Detect unexpected colors, modifiers, and pack sizes.
- Add catalog statistics (mesh counts, colors, etc.).
