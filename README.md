# Shur-Loc Product Tools

Utilities for managing and analyzing the Shur-Loc® WooCommerce product catalog.

## Features

- Export WooCommerce product variation names.
- Parse and recognize Shur-Loc mesh specifications.
- Analyze the product catalog for recognized, unrecognized, and invalid mesh specifications.
- Generate machine-readable JSON reports for parser development and validation.

## Requirements

- WordPress 7.0 or later
- WooCommerce
- PHP 8.4 or later

## Installation

1. Install and activate the plugin.
2. Navigate to **Tools → Shur-Loc Product Tools**.
3. Use the available tools to export catalog data or generate analysis reports.

## Development

The project includes:

- PHPUnit integration and unit tests
- PHP_CodeSniffer configuration
- PowerShell build script for creating release packages

Run the test suite:

```bash
composer test
```

Run code style checks:

```bash
composer lint
```

Create a release package:

```powershell
.\bin\build.ps1
```

## License

This project is licensed under the MIT License. See the LICENSE file for details.
