<?php
/**
 * Product catalog service interface.
 *
 * Defines catalog product and variation retrieval behavior.
 *
 * @package ShurlocProductTools
 */

declare( strict_types=1 );

/**
 * Product catalog service interface.
 */
interface Shurloc_Product_Catalog_Service_Interface {

	/**
	 * Get catalog product entry.
	 *
	 * Converts a WooCommerce product into a catalog product entry.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return Shurloc_Catalog_Product_Entry|null Product entry or null.
	 */
	public function get_product_entry(
		WC_Product $product
	): ?Shurloc_Catalog_Product_Entry;

	/**
	 * Get catalog variation entries.
	 *
	 * Converts WooCommerce product variations into catalog variation
	 * entries for mesh analysis and reporting.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return Shurloc_Catalog_Variation_Entry[] Variation entries.
	 */
	public function get_product_variation_entries(
		WC_Product $product
	): array;
}
