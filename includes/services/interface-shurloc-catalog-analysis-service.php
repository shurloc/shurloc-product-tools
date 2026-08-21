<?php
/**
 * Catalog analysis service interface.
 *
 * @package ShurlocProductTools
 */

declare( strict_types=1 );

/**
 * Provides catalog variation collection and analysis.
 */
interface Shurloc_Catalog_Analysis_Service_Interface {

	/**
	 * Collect catalog variation entries.
	 *
	 * @return Shurloc_Catalog_Variation_Entry[]
	 */
	public function get_variation_entries(): array;

	/**
	 * Collect catalog variation values.
	 *
	 * @return string[]
	 */
	public function get_variation_values(): array;

	/**
	 * Analyze the WooCommerce catalog.
	 *
	 * @return Shurloc_Catalog_Report
	 */
	public function analyze(): Shurloc_Catalog_Report;
}
