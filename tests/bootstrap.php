<?php
/**
 * PHPUnit bootstrap.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __DIR__ ) . DIRECTORY_SEPARATOR );
}

/*
 * Load Composer's autoloader.
 */
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

/*
 * Load the classes under test.
 *
 * As the plugin grows, we'll either:
 *   1. Continue requiring files here, or
 *   2. Add a PSR-4 autoloader for the plugin itself (my preference).
 */
require_once dirname( __DIR__ ) . '/includes/models/class-shurloc-mesh-specification.php';
require_once dirname( __DIR__ ) . '/includes/parsers/class-shurloc-mesh-parser.php';
require_once dirname( __DIR__ ) . '/includes/analyzers/class-shurloc-catalog-analyzer.php';
require_once dirname( __DIR__ ) . '/includes/reports/class-shurloc-catalog-report.php';
require_once dirname( __DIR__ ) . '/includes/models/class-shurloc-catalog-variation-entry.php';

// Testing imports.
require_once dirname( __DIR__ ) . '/tests/parsers/MeshParserDataProvider.php';
require_once dirname( __DIR__ ) . '/tests//integration/MeshCatalogDataProvider.php';
