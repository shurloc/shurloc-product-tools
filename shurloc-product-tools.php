<?php
/**
 * Plugin Name:       Shur-loc Product Tools
 * Plugin URI:        https://github.com/shurloc/shurloc-product-tools
 * Description:       Custom WooCommerce enhancements and product tools for the Shur-loc website.
 * Version:           1.6.0
 * Requires at least: 7.0
 * Requires PHP:      8.4
 * Requires Plugins:  woocommerce, wordpress-seo, shurloc-tools
 * Author:            Shur-loc
 * Author URI:        https://shurloc.com/
 * Text Domain:       shurloc-product-tools
 *
 * @package ShurlocProductTools
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/includes/constants.php';
require_once __DIR__ . '/includes/bootstrap.php';
