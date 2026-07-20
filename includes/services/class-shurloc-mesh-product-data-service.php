<?php
/**
 * Mesh product data service.
 *
 * Provides analyzed mesh product data for frontend displays,
 * structured data generation, and other integrations.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product data service.
 */
final class Shurloc_Mesh_Product_Data_Service {

	/**
	 * Product catalog service.
	 *
	 * @var Shurloc_Product_Catalog_Service_Interface
	 */
	private Shurloc_Product_Catalog_Service_Interface $catalog_service;

	/**
	 * Mesh product analyzer.
	 *
	 * @var Shurloc_Mesh_Product_Analyzer_Interface
	 */
	private Shurloc_Mesh_Product_Analyzer_Interface $mesh_analyzer;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Product_Catalog_Service_Interface $catalog_service Catalog service.
	 * @param Shurloc_Mesh_Product_Analyzer_Interface   $mesh_analyzer   Mesh analyzer.
	 */
	public function __construct(
		Shurloc_Product_Catalog_Service_Interface $catalog_service,
		Shurloc_Mesh_Product_Analyzer_Interface $mesh_analyzer
	) {

		$this->catalog_service = $catalog_service;
		$this->mesh_analyzer   = $mesh_analyzer;
	}

	/**
	 * Get analyzed mesh data for a product.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return Shurloc_Mesh_Product_Result
	 */
	public function analyze_product(
		WC_Product $product
	): Shurloc_Mesh_Product_Result {

		$entries = $this->catalog_service->get_product_variation_entries(
			$product
		);

		return $this->mesh_analyzer->analyze(
			$entries
		);
	}

	/**
	 * Determine whether a product is a mesh product.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return bool True if mesh specifications exist.
	 */
	public function is_mesh_product(
		WC_Product $product
	): bool {

		return $this->get_product_mesh_data(
			$product
		)->is_mesh_product();
	}

	/**
	 * Get analyzed mesh data for a product.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return Shurloc_Mesh_Product_Result Analysis result.
	 */
	public function get_product_mesh_data(
		WC_Product $product
	): Shurloc_Mesh_Product_Result {

		$entries = $this->catalog_service->get_product_variation_entries(
			$product
		);

		return $this->mesh_analyzer->analyze(
			$entries
		);
	}
}
