<?php
/**
 * Mesh product schema service.
 *
 * Coordinates mesh product detection and schema generation.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product schema service.
 */
final class Shurloc_Mesh_Product_Schema_Service {

	/**
	 * Catalog service.
	 *
	 * @var Shurloc_Product_Catalog_Service
	 */
	private Shurloc_Product_Catalog_Service $catalog_service;

	/**
	 * Mesh analyzer.
	 *
	 * @var Shurloc_Mesh_Product_Analyzer
	 */
	private Shurloc_Mesh_Product_Analyzer $analyzer;

	/**
	 * Schema generator.
	 *
	 * @var Shurloc_Product_Schema_Generator
	 */
	private Shurloc_Product_Schema_Generator $generator;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Product_Catalog_Service  $catalog_service Catalog service.
	 * @param Shurloc_Mesh_Product_Analyzer    $analyzer Mesh analyzer.
	 * @param Shurloc_Product_Schema_Generator $generator Schema generator.
	 */
	public function __construct(
		Shurloc_Product_Catalog_Service $catalog_service,
		Shurloc_Mesh_Product_Analyzer $analyzer,
		Shurloc_Product_Schema_Generator $generator
	) {

		$this->catalog_service = $catalog_service;
		$this->analyzer        = $analyzer;
		$this->generator       = $generator;
	}

	/**
	 * Generate schema for a WooCommerce product.
	 *
	 * Returns null when the product is not a mesh product.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return array<string,mixed>|null
	 */
	public function generate_for_product(
		WC_Product $product
	): ?array {

		$entries = $this->catalog_service->get_product_variation_entries(
			$product
		);

		$result = $this->analyzer->analyze(
			$entries
		);

		if ( 0 === $result->mesh_variation_count() ) {
			return null;
		}

		return $this->generator->generate(
			$product->get_name(),
			$result
		);
	}
}
