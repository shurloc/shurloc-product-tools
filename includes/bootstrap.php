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

	// Future module loading goes here.
}

add_action( 'plugins_loaded', 'shurloc_product_tools_bootstrap' );
