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

		/**
		 * Variation attributes.
		 *
		 * @var array<string,string>
		 */
		private array $test_variation_attributes = array();

		/**
		 * Set variation attributes.
		 *
		 * @param array<string,string> $attributes Attributes.
		 * @return void
		 */
		public function set_variation_attributes(
			array $attributes
		): void {

			$this->test_variation_attributes = $attributes;
		}

		/**
		 * Get variation attributes.
		 *
		 * @return array<string,string>
		 */
		public function get_variation_attributes(): array {

			return $this->test_variation_attributes;
		}
	}
}
