<?php
/**
 * Mesh product schema service.
 *
 * Coordinates mesh product analysis.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product schema service.
 */
final class Shurloc_Mesh_Product_Schema_Service {

	/**
	 * Mesh analyzer.
	 *
	 * @var Shurloc_Mesh_Product_Analyzer
	 */
	private Shurloc_Mesh_Product_Analyzer $analyzer;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Mesh_Product_Analyzer $analyzer Mesh analyzer.
	 */
	public function __construct(
		Shurloc_Mesh_Product_Analyzer $analyzer
	) {

		$this->analyzer = $analyzer;
	}

	/**
	 * Analyze a catalog product for mesh variations.
	 *
	 * Returns null when the product is not a mesh product.
	 *
	 * @param Shurloc_Catalog_Product_Entry $product Catalog product.
	 * @return Shurloc_Mesh_Product_Result|null
	 */
	public function analyze(
		Shurloc_Catalog_Product_Entry $product
	): ?Shurloc_Mesh_Product_Result {

		$result = $this->analyzer->analyze(
			$product->variations
		);

		if ( ! $result->is_mesh_product() ) {
			return null;
		}

		return $result;
	}
}
