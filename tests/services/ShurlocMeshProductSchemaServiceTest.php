<?php
/**
 * Tests for mesh product schema service.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests mesh product schema generation.
 */
final class ShurlocMeshProductSchemaServiceTest extends TestCase {

	/**
	 * Mesh products should generate schema.
	 */
	public function test_generates_schema_for_mesh_product(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			123,
			'Test Mesh Product',
			'',
			'https://example.com/product/test-mesh-product/',
			'TEST-MESH-123',
			'https://example.com/wp-content/uploads/test-mesh-product.jpg',
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

		$service = new Shurloc_Mesh_Product_Schema_Service(
			new Shurloc_Mesh_Product_Analyzer(
				new Shurloc_Mesh_Parser()
			),
			new Shurloc_Product_Schema_Generator()
		);

		$schema = $service->generate(
			$product
		);

		$this->assertNotNull(
			$schema
		);

		$this->assertSame(
			'Product',
			$schema['@type']
		);

		$this->assertSame(
			'Test Mesh Product',
			$schema['name']
		);

		$this->assertCount(
			1,
			$schema['offers']
		);
	}

	/**
	 * Products without mesh variations should not generate schema.
	 */
	public function test_non_mesh_products_return_null(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			456,
			'Non Mesh Product',
			'',
			'https://example.com/product/non-mesh-product/',
			'',
			null,
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

		$service = new Shurloc_Mesh_Product_Schema_Service(
			new Shurloc_Mesh_Product_Analyzer(
				new Shurloc_Mesh_Parser()
			),
			new Shurloc_Product_Schema_Generator()
		);

		$schema = $service->generate(
			$product
		);

		$this->assertNull(
			$schema
		);
	}

	/**
	 * Multiple mesh variations should generate multiple offers.
	 */
	public function test_multiple_mesh_variations_generate_multiple_offers(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			123,
			'Test Mesh Product',
			'',
			'https://example.com/product/test-mesh-product/',
			'TEST-MESH-123',
			'https://example.com/wp-content/uploads/test-mesh-product.jpg',
			array(
				new Shurloc_Catalog_Variation_Entry(
					'110/80 Yellow $20.00',
					20.0,
					123,
					'Test Mesh Product',
					''
				),
				new Shurloc_Catalog_Variation_Entry(
					'160/64 Yellow $25.00',
					25.0,
					123,
					'Test Mesh Product',
					''
				),
			)
		);

		$service = new Shurloc_Mesh_Product_Schema_Service(
			new Shurloc_Mesh_Product_Analyzer(
				new Shurloc_Mesh_Parser()
			),
			new Shurloc_Product_Schema_Generator()
		);

		$schema = $service->generate(
			$product
		);

		$this->assertNotNull(
			$schema
		);

		$this->assertCount(
			2,
			$schema['offers'],
			'Each mesh variation should generate its own offer.'
		);

		$this->assertSame(
			'20.00',
			$schema['offers'][0]['price']
		);

		$this->assertSame(
			'25.00',
			$schema['offers'][1]['price']
		);
	}
}
