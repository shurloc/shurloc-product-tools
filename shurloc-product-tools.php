<?php
/**
 * Plugin Name:       Shur-Loc Product Tools
 * Plugin URI:        https://shurloc.com/
 * Description:       Custom WooCommerce enhancements and product tools for the Shur-Loc website.
 * Version:           1.3.7
 * Requires at least: 7.0
 * Requires PHP:      8.4
 * Requires Plugins:  woocommerce, wordpress-seo, shurloc-tools
 * Author:            Shur-Loc
 * Author URI:        https://shurloc.com/
 * Text Domain:       shurloc-product-tools
 *
 * @package ShurLocProductTools
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/includes/constants.php';
require_once __DIR__ . '/includes/bootstrap.php';
