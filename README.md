# Shur-loc Product Tools

Utilities for managing, analyzing, and enhancing the Shur-loc® WooCommerce product catalog.

## Features

- Parse and recognize Shur-loc mesh specifications.
- Analyze the WooCommerce product catalog for recognized, unrecognized, and invalid mesh specifications.
- Provide admin reports for reviewing catalog and mesh specification data.
- Generate machine-readable JSON reports for parser development and validation.
- Export WooCommerce product variation names.
- Manage product recommendation logic, including related products and cross-sells.
- Customize WooCommerce product breadcrumbs.
- Enhance WooCommerce product structured data.

## Requirements

- WordPress 7.0 or later
- WooCommerce
- Shur-loc Tools
- PHP 8.4 or later

## Installation

1. Install and activate **Shur-loc Tools**.
2. Install and activate **Shur-loc Product Tools**.
3. Navigate to **Shur-loc Tools → Products** in the WordPress admin.
4. Use the available product tools and reports as needed.

## Development

### Dependencies

Shur-loc Product Tools depends on the shared **Shur-loc Tools** plugin for common infrastructure and admin interfaces.

For development, both repositories should be checked out as sibling directories:

```text
wordpress-plugins/
├── shurloc-tools/
└── shurloc-product-tools/
```

This layout allows development and static-analysis tooling to resolve classes and interfaces provided by `shurloc-tools`.

Install the development dependencies with Composer:

```bash
composer install
```

### PHPUnit

The project includes PHPUnit unit tests covering product catalog services, mesh parsing and analysis, admin functionality, recommendations, and other plugin behavior.

Run the test suite:

```bash
composer test
```

### PHP_CodeSniffer

PHP_CodeSniffer is used to enforce the project's PHP coding standards.

Run code style checks:

```bash
composer lint
```

### PHPStan

PHPStan is used for static analysis of the plugin source and test suite.

Run static analysis:

```bash
composer phpstan
```

### Release Packages

A PowerShell build script is provided for creating distributable plugin packages:

```powershell
.\bin\build.ps1
```

Development files, tests, static-analysis configuration, and other files not required at runtime are excluded from release packages.

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.
