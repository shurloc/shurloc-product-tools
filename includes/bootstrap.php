<?php
/**
 * Plugin bootstrap.
 *
 * Loads and initializes the Shur-Loc Product Tools plugin.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bootstrap the plugin.
 */
function shurloc_product_tools_bootstrap(): void {

	// Module loading goes here.
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/models/class-shurloc-mesh-specification.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/parsers/class-shurloc-mesh-parser.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/analyzers/class-shurloc-catalog-analyzer.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/reports/class-shurloc-catalog-report.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/models/class-shurloc-catalog-variation-entry.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/models/class-shurloc-mesh-product-result.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/analyzers/class-shurloc-mesh-product-analyzer.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/services/class-shurloc-product-catalog-service.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/generators/class-shurloc-product-schema-generator.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/services/class-shurloc-mesh-product-schema-service.php';

	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/admin/catalog-report.php';
}

add_action( 'plugins_loaded', 'shurloc_product_tools_bootstrap' );
