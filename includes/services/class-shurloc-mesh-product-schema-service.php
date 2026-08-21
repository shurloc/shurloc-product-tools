<?php
/**
 * Mesh product schema service.
 *
 * Coordinates mesh product analysis.
 *
 * @package ShurlocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product schema service.
 */
final class Shurloc_Mesh_Product_Schema_Service implements Shurloc_Mesh_Product_Schema_Service_Interface {

	/**
	 * Mesh analyzer.
	 *
	 * @var Shurloc_Mesh_Product_Analyzer_Interface
	 */
	private Shurloc_Mesh_Product_Analyzer_Interface $analyzer;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Mesh_Product_Analyzer_Interface $analyzer Mesh analyzer.
	 */
	public function __construct(
		Shurloc_Mesh_Product_Analyzer_Interface $analyzer
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
