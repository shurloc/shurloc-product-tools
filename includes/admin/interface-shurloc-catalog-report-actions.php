<?php
/**
 * Catalog report actions interface.
 *
 * Defines actions that can be triggered by catalog report requests.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Catalog report actions contract.
 */
interface Shurloc_Catalog_Report_Actions_Interface {

	/**
	 * Export WooCommerce catalog variations.
	 *
	 * @return void
	 */
	public function export_variations(): void;

	/**
	 * Generate catalog analysis report.
	 *
	 * @return void
	 */
	public function generate_catalog_report(): void;
}
