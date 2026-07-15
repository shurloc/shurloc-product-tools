<?php
/**
 * WooCommerce product test double.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Minimal WooCommerce product test double.
 */
if ( ! class_exists( 'WC_Product' ) ) {

	/**
	 * WooCommerce product test double.
	 */
	class WC_Product {

		/**
		 * Product ID.
		 *
		 * @var int
		 */
		private int $id;

		/**
		 * Constructor.
		 *
		 * @param int $id Product ID.
		 */
		public function __construct(
			int $id
		) {

			$this->id = $id;
		}

		/**
		 * Get product ID.
		 *
		 * @return int Product ID.
		 */
		public function get_id(): int {

			return $this->id;
		}
	}
}
