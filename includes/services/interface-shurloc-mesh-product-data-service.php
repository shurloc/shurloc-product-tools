<?php
/**
 * Mesh product data service interface.
 *
 * Defines mesh product data retrieval behavior.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product data service interface.
 */
interface Shurloc_Mesh_Product_Data_Service_Interface {

	/**
	 * Analyze a WooCommerce product for mesh data.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return Shurloc_Mesh_Product_Result Mesh product analysis result.
	 */
	public function analyze_product(
		WC_Product $product
	): Shurloc_Mesh_Product_Result;

	/**
	 * Determine whether a product contains mesh specifications.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return bool True if the product contains mesh specifications.
	 */
	public function is_mesh_product(
		WC_Product $product
	): bool;
}
