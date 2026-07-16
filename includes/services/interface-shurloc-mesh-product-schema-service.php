<?php
/**
 * Mesh product schema service interface.
 *
 * Defines the contract for analyzing mesh products for schema enrichment.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product schema service interface.
 */
interface Shurloc_Mesh_Product_Schema_Service_Interface {

	/**
	 * Analyze a catalog product for mesh schema data.
	 *
	 * Returns mesh product analysis results when applicable,
	 * otherwise returns null.
	 *
	 * @param Shurloc_Catalog_Product_Entry $product Catalog product.
	 * @return ?Shurloc_Mesh_Product_Result Mesh result or null.
	 */
	public function analyze(
		Shurloc_Catalog_Product_Entry $product
	): ?Shurloc_Mesh_Product_Result;
}
