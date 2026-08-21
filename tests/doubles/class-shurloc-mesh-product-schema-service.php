<?php
/**
 * Test double for mesh product schema service.
 *
 * @package ShurlocProductTools
 */

declare( strict_types=1 );

/**
 * Configurable mesh product schema service test double.
 */
final class Shurloc_Mesh_Product_Schema_Service_Double implements Shurloc_Mesh_Product_Schema_Service_Interface {

	/**
	 * Analysis result returned by the double.
	 *
	 * @var Shurloc_Mesh_Product_Result|null
	 */
	private ?Shurloc_Mesh_Product_Result $result;

	/**
	 * Products passed to analyze().
	 *
	 * @var Shurloc_Catalog_Product_Entry[]
	 */
	private array $calls = array();


	/**
	 * Create the test double.
	 *
	 * @param Shurloc_Mesh_Product_Result|null $result Analysis result.
	 */
	public function __construct(
		?Shurloc_Mesh_Product_Result $result = null
	) {

		$this->result = $result;
	}


	/**
	 * Analyze a catalog product.
	 *
	 * @param Shurloc_Catalog_Product_Entry $product Catalog product.
	 * @return Shurloc_Mesh_Product_Result|null
	 */
	public function analyze(
		Shurloc_Catalog_Product_Entry $product
	): ?Shurloc_Mesh_Product_Result {

		$this->calls[] = $product;

		return $this->result;
	}


	/**
	 * Get products passed to analyze().
	 *
	 * @return Shurloc_Catalog_Product_Entry[]
	 */
	public function get_calls(): array {

		return $this->calls;
	}
}
