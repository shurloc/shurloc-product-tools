<?php
/**
 * Product schema service.
 *
 * Coordinates product schema generation and mesh product enrichment.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Product schema service.
 */
final class Shurloc_Product_Schema_Service implements Shurloc_Product_Schema_Service_Interface {

	/**
	 * Schema generator.
	 *
	 * @var Shurloc_Product_Schema_Generator
	 */
	private Shurloc_Product_Schema_Generator $generator;

	/**
	 * Mesh product schema service.
	 *
	 * @var Shurloc_Mesh_Product_Schema_Service
	 */
	private Shurloc_Mesh_Product_Schema_Service $mesh_schema_service;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Product_Schema_Generator    $generator Schema generator.
	 * @param Shurloc_Mesh_Product_Schema_Service $mesh_schema_service Mesh schema service.
	 */
	public function __construct(
		Shurloc_Product_Schema_Generator $generator,
		Shurloc_Mesh_Product_Schema_Service $mesh_schema_service
	) {

		$this->generator           = $generator;
		$this->mesh_schema_service = $mesh_schema_service;
	}

	/**
	 * Generate schema for a catalog product.
	 *
	 * Returns base product schema for all products and enriches mesh products
	 * with aggregate offers.
	 *
	 * @param Shurloc_Catalog_Product_Entry $product Catalog product.
	 * @return array<string,mixed>
	 */
	public function generate(
		Shurloc_Catalog_Product_Entry $product
	): array {

		$result = $this->mesh_schema_service->analyze(
			$product
		);

		if ( null === $result ) {

			$result = new Shurloc_Mesh_Product_Result();
		}

		return $this->generator->generate(
			$product,
			$result
		);
	}
}
