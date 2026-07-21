<?php
/**
 * Mesh product data service double.
 *
 * Provides controlled mesh product analysis results for tests.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product data service double.
 */
final class Shurloc_Mesh_Product_Data_Service_Double implements Shurloc_Mesh_Product_Data_Service_Interface {

	/**
	 * Analysis result.
	 *
	 * @var Shurloc_Mesh_Product_Result
	 */
	private Shurloc_Mesh_Product_Result $result;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Mesh_Product_Result $result Analysis result.
	 */
	public function __construct(
		Shurloc_Mesh_Product_Result $result
	) {

		$this->result = $result;
	}

	/**
	 * Analyze product.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return Shurloc_Mesh_Product_Result
	 */
	public function analyze_product(
		WC_Product $product
	): Shurloc_Mesh_Product_Result {

		return $this->result;
	}

	/**
	 * Determine whether product contains mesh data.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return bool True if mesh product.
	 */
	public function is_mesh_product(
		WC_Product $product
	): bool {

		return $this->result->is_mesh_product();
	}
}
