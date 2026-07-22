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

// Load Composer's autoloader.
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

/*
 * Load plugin autoloader.
 *
 * The autoloader cannot load itself, so this remains a manual include.
 */
require_once dirname( __DIR__ ) . '/includes/class-shurloc-autoloader.php';

$shurloc_autoloader = new Shurloc_Autoloader(
	dirname( __DIR__ ) . '/includes'
);

$shurloc_autoloader->register();

/*
 * Load test utilities.
 */
require_once dirname( __DIR__ ) . '/tests/parsers/MeshParserDataProvider.php';
require_once dirname( __DIR__ ) . '/tests/integration/MeshCatalogDataProvider.php';

/*
 * Load WordPress function stubs.
 */
require_once dirname( __DIR__ ) . '/tests/stubs/wordpress-functions.php';

/*
 * Load helper functions.
 */
require_once dirname( __DIR__ ) . '/tests/stubs/shurloc-helpers.php';

/*
 * Load interfaces required by test doubles.
 */
require_once dirname( __DIR__ ) . '/includes/admin/interface-shurloc-catalog-report-actions.php';

/*
 * Load WordPress test doubles.
 */
require_once dirname( __DIR__ ) . '/tests/doubles/class-wc-product.php';
require_once dirname( __DIR__ ) . '/tests/doubles/class-wc-product-variation.php';
require_once dirname( __DIR__ ) . '/tests/doubles/class-shurloc-catalog-report-actions.php';
require_once dirname( __DIR__ ) . '/tests/doubles/class-shurloc-product-catalog-service.php';
require_once dirname( __DIR__ ) . '/tests/doubles/class-shurloc-mesh-product-analyzer.php';
require_once dirname( __DIR__ ) . '/tests/doubles/class-shurloc-mesh-product-table-renderer.php';
require_once dirname( __DIR__ ) . '/tests/doubles/class-shurloc-mesh-product-data-service.php';
require_once dirname( __DIR__ ) . '/tests/doubles/class-wp-post.php';
