<?php
/**
 * Plugin constants.
 *
 * Defines global constants used throughout the plugin.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin version.
 */
define( 'SHURLOC_PRODUCT_TOOLS_VERSION', '1.0.1' );

/**
 * Plugin directory path.
 */
define( 'SHURLOC_PRODUCT_TOOLS_PATH', plugin_dir_path( __DIR__ ) );

/**
 * Plugin directory URL.
 */
define( 'SHURLOC_PRODUCT_TOOLS_URL', plugin_dir_url( __DIR__ ) );
