<?php
/**
 * Extended WooCommerce product variation test double.
 *
 * Adds helper methods used only by tests that are not part of the real
 * WooCommerce WC_Product_Variation API.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

if ( ! class_exists( 'Shurloc_Test_WC_Product_Variation' ) ) {

	/**
	 * Extended WooCommerce product variation test double.
	 */
	class Shurloc_Test_WC_Product_Variation extends Shurloc_Test_WC_Product {

	}
}
