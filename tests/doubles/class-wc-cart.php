<?php
/**
 * WooCommerce cart test double.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

if ( ! class_exists( 'WC_Cart' ) ) {

	/**
	 * WooCommerce cart test double.
	 */
	class WC_Cart {

		/**
		 * Cart items.
		 *
		 * @var array<int,array<string,mixed>>
		 */
		private array $cart = array();

		/**
		 * Set cart items.
		 *
		 * @param array<int,array<string,mixed>> $cart Cart items.
		 *
		 * @return void
		 */
		public function set_cart(
			array $cart
		): void {

			$this->cart = $cart;
		}

		/**
		 * Get cart items.
		 *
		 * @return array<int,array<string,mixed>>
		 */
		public function get_cart(): array {

			return $this->cart;
		}
	}
}
