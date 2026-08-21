<?php
/**
 * Shurloc helper functions.
 *
 * @package ShurlocProductTools
 */

declare( strict_types=1 );

if ( ! function_exists( 'shurloc_reset_test_products' ) ) {
	/**
	 * Reset registered WooCommerce products.
	 *
	 * @return void
	 */
	function shurloc_reset_test_products(): void {

		$GLOBALS['shurloc_test_products'] = array();
	}
}
