<?php
/**
 * Tests for mesh product schema service.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests mesh product schema enrichment.
 */
final class ShurlocMeshProductSchemaServiceTest extends TestCase {

	/**
	 * Mesh products should return mesh analysis results.
	 */
	public function test_mesh_products_return_mesh_result(): void {

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

		$service = new Shurloc_Mesh_Product_Schema_Service(
			new Shurloc_Mesh_Product_Analyzer(
				new Shurloc_Mesh_Parser()
			),
			new Shurloc_Product_Schema_Generator()
		);

		$result = $service->analyze(
			$product
		);

		$this->assertNotNull(
			$result
		);

		$this->assertInstanceOf(
			Shurloc_Mesh_Product_Result::class,
			$result
		);

		$this->assertSame(
			1,
			$result->mesh_variation_count()
		);
	}

	/**
	 * Non-mesh products should return null.
	 */
	public function test_non_mesh_products_return_null(): void {

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

		$service = new Shurloc_Mesh_Product_Schema_Service(
			new Shurloc_Mesh_Product_Analyzer(
				new Shurloc_Mesh_Parser()
			),
			new Shurloc_Product_Schema_Generator()
		);

		$result = $service->analyze(
			$product
		);

		$this->assertNull(
			$result
		);
	}

	/**
	 * Mesh analysis should preserve variation data.
	 */
	public function test_mesh_analysis_preserves_variation_data(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			123,
			'Test Mesh Product',
			'',
			'https://example.com/product/test-mesh-product/',
			'TEST-MESH-123',
			'https://example.com/image.jpg',
			array(
				new Shurloc_Catalog_Variation_Entry(
					'160/64 White $25.00',
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

		$result = $service->analyze(
			$product
		);

		$this->assertNotNull(
			$result
		);

		$this->assertSame(
			1,
			$result->mesh_variation_count()
		);

		$variation = $result->mesh_variations[0];

		$this->assertSame(
			'160/64 White $25.00',
			$variation['entry']->variation
		);

		$this->assertSame(
			25.0,
			$variation['entry']->price
		);

		$this->assertSame(
			160,
			$variation['spec']->mesh_count
		);

		$this->assertSame(
			64,
			$variation['spec']->thread_diameter
		);

		$this->assertSame(
			'White',
			$variation['spec']->color
		);
	}
}
