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

		$service = $this->create_service();

		$result = $service->analyze(
			$this->create_mesh_product_entry()
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

		$service = $this->create_service();

		$result = $service->analyze(
			$this->create_non_mesh_product_entry()
		);

		$this->assertNull(
			$result
		);
	}

	/**
	 * Mesh analysis should preserve variation data.
	 */
	public function test_mesh_analysis_preserves_variation_data(): void {

		$service = $this->create_service();

		$result = $service->analyze(
			$this->create_mesh_product_entry(
				'160/64 White $25.00',
				25.0
			)
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

	/**
	 * Create mesh schema service.
	 *
	 * @return Shurloc_Mesh_Product_Schema_Service
	 */
	private function create_service(): Shurloc_Mesh_Product_Schema_Service {

		return new Shurloc_Mesh_Product_Schema_Service(
			new Shurloc_Mesh_Product_Analyzer(
				new Shurloc_Mesh_Parser()
			),
			new Shurloc_Product_Schema_Generator()
		);
	}

	/**
	 * Create mesh product fixture.
	 *
	 * @param string $variation Variation text.
	 * @param float  $price Variation price.
	 * @return Shurloc_Catalog_Product_Entry
	 */
	private function create_mesh_product_entry(
		string $variation = '110/80 Yellow $20.00',
		float $price = 20.0
	): Shurloc_Catalog_Product_Entry {

		return new Shurloc_Catalog_Product_Entry(
			123,
			'Test Mesh Product',
			'',
			'https://example.com/product/test-mesh-product/',
			'TEST-MESH-123',
			'https://example.com/image.jpg',
			null,
			null,
			null,
			'https://schema.org/InStock',
			array(
				new Shurloc_Catalog_Variation_Entry(
					$variation,
					$price,
					123,
					'Test Mesh Product',
					''
				),
			)
		);
	}

	/**
	 * Create non-mesh product fixture.
	 *
	 * @return Shurloc_Catalog_Product_Entry
	 */
	private function create_non_mesh_product_entry(): Shurloc_Catalog_Product_Entry {

		return new Shurloc_Catalog_Product_Entry(
			456,
			'Non Mesh Product',
			'',
			'https://example.com/product/non-mesh-product/',
			'NON-MESH-456',
			'https://example.com/non-mesh-image.jpg',
			15.0,
			15.0,
			null,
			'https://schema.org/InStock',
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
	}
}
