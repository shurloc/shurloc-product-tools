<?php
/**
 * Plugin bootstrap.
 *
 * Loads and initializes the Shur-Loc Product Tools plugin.
 *
 * @package ShurLocProductTools
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bootstrap the plugin.
 */
function shurloc_product_tools_bootstrap(): void {

	// Module loading goes here.
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/products/class-shurloc-mesh-specification.php';
}

add_action( 'plugins_loaded', 'shurloc_product_tools_bootstrap' );
