<?php
/**
 * Tests for product schema service.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests product schema generation.
 */
final class ShurlocProductSchemaServiceTest extends TestCase {

	/**
	 * Products should generate base schema.
	 */
	public function test_generates_schema_for_product(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			123,
			'Test Mesh Product',
			'',
			'https://example.com/product/test-mesh-product/',
			'TEST-MESH-123',
			'https://example.com/image.jpg',
			array(
				new Shurloc_Catalog_Variation_Entry(
					'110/80 Yellow $20.00',
					20.0,
					123,
					'Test Mesh Product',
					''
				),
			)
		);

		$mesh_schema_service = new Shurloc_Mesh_Product_Schema_Service(
			new Shurloc_Mesh_Product_Analyzer(
				new Shurloc_Mesh_Parser()
			),
			new Shurloc_Product_Schema_Generator()
		);

		$service = new Shurloc_Product_Schema_Service(
			new Shurloc_Product_Schema_Generator(),
			$mesh_schema_service
		);

		$schema = $service->generate(
			$product
		);

		$this->assertSame(
			'Product',
			$schema['@type']
		);

		$this->assertSame(
			'Test Mesh Product',
			$schema['name']
		);

		$this->assertSame(
			'https://example.com/product/test-mesh-product/#product',
			$schema['@id']
		);

		$this->assertSame(
			'https://example.com/product/test-mesh-product/',
			$schema['url']
		);

		$this->assertSame(
			'TEST-MESH-123',
			$schema['sku']
		);

		$this->assertSame(
			'https://example.com/image.jpg',
			$schema['image']
		);

		$this->assertArrayHasKey(
			'offers',
			$schema
		);
	}

	/**
	 * Non-mesh products should still generate base product schema.
	 */
	public function test_non_mesh_products_generate_base_schema(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			456,
			'Non Mesh Product',
			'',
			'https://example.com/product/non-mesh-product/',
			'NON-MESH-456',
			'https://example.com/non-mesh-image.jpg',
			array(
				new Shurloc_Catalog_Variation_Entry(
					'Thin Thread',
					null,
					456,
					'Non Mesh Product',
					''
				),
			)
		);

		$mesh_schema_service = new Shurloc_Mesh_Product_Schema_Service(
			new Shurloc_Mesh_Product_Analyzer(
				new Shurloc_Mesh_Parser()
			),
			new Shurloc_Product_Schema_Generator()
		);

		$service = new Shurloc_Product_Schema_Service(
			new Shurloc_Product_Schema_Generator(),
			$mesh_schema_service
		);

		$schema = $service->generate(
			$product
		);

		$this->assertSame(
			'Product',
			$schema['@type']
		);

		$this->assertSame(
			'Non Mesh Product',
			$schema['name']
		);

		$this->assertArrayNotHasKey(
			'offers',
			$schema
		);
	}
}
