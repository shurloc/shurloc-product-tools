<?php
/**
 * Product schema service interface.
 *
 * Defines the contract for generating product schema data.
 *
 * @package ShurlocProductTools
 */

declare( strict_types=1 );

/**
 * Product schema service interface.
 */
interface Shurloc_Product_Schema_Service_Interface {

	/**
	 * Generate product schema.
	 *
	 * @param Shurloc_Catalog_Product_Entry $product Catalog product.
	 * @return array<string,mixed>|null
	 */
	public function generate(
		Shurloc_Catalog_Product_Entry $product
	): ?array;
}
