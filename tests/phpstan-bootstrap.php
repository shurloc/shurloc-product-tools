<?php
/**
 * PHPStan bootstrap.
 *
 * @package ShurlocProductTools
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/../' );
}

if ( ! defined( 'SHURLOC_PRODUCT_TOOLS_VERSION' ) ) {
	define(
		'SHURLOC_PRODUCT_TOOLS_VERSION',
		'0.1.0'
	);
}

if ( ! defined( 'SHURLOC_PRODUCT_TOOLS_PATH' ) ) {
	define(
		'SHURLOC_PRODUCT_TOOLS_PATH',
		__DIR__ . '/'
	);
}

if ( ! defined( 'SHURLOC_PRODUCT_TOOLS_URL' ) ) {
	define(
		'SHURLOC_PRODUCT_TOOLS_URL',
		'https://example.com/wp-content/plugins/shurloc-product-tools/'
	);
}

/**
 * Load dependencies from shurloc-tools.
 */

require_once dirname( __DIR__, 2 ) . '/shurloc-tools/includes/interfaces/interface-shurloc-admin-page.php';
