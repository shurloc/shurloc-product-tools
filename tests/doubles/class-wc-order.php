<?php
/**
 * WooCommerce order test double.
 *
 * @package ShurlocProductTools
 */

declare( strict_types=1 );

if ( ! class_exists( 'WC_Order' ) ) {

	/**
	 * WooCommerce order test double.
	 */
	class WC_Order {

		/**
		 * Order ID.
		 *
		 * @var int
		 */
		private int $id;

		/**
		 * Billing company.
		 *
		 * @var string
		 */
		private string $billing_company = '';

		/**
		 * Constructor.
		 *
		 * @param int $order_id Order ID.
		 */
		public function __construct(
			int $order_id = 0
		) {

			$this->id = $order_id;
		}

		/**
		 * Get the order ID.
		 *
		 * @return int
		 */
		public function get_id(): int {

			return $this->id;
		}

		/**
		 * Get the billing company.
		 *
		 * @return string
		 */
		public function get_billing_company(): string {

			return $this->billing_company;
		}

		/**
		 * Set the billing company.
		 *
		 * @param string $company Billing company.
		 * @return void
		 */
		public function set_billing_company(
			string $company
		): void {

			$this->billing_company = $company;
		}
	}
}
