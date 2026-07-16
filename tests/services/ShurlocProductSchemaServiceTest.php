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
	 * Mesh products should generate aggregate offers.
	 */
	public function test_mesh_products_generate_aggregate_offer(): void {

		$schema = $this->create_service()->generate(
			$this->create_mesh_product_entry()
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
			'AggregateOffer',
			$schema['offers']['@type']
		);

		$this->assertSame(
			'20.00',
			$schema['offers']['lowPrice']
		);

		$this->assertSame(
			'20.00',
			$schema['offers']['highPrice']
		);

		$this->assertSame(
			1,
			$schema['offers']['offerCount']
		);
	}

	/**
	 * Non-mesh products should generate standard offers.
	 */
	public function test_non_mesh_products_generate_standard_offer(): void {

		$schema = $this->create_service()->generate(
			$this->create_non_mesh_product_entry()
		);

		$this->assertSame(
			'Product',
			$schema['@type']
		);

		$this->assertSame(
			'Non Mesh Product',
			$schema['name']
		);

		$this->assertArrayHasKey(
			'offers',
			$schema
		);

		$this->assertSame(
			'Offer',
			$schema['offers']['@type']
		);

		$this->assertSame(
			'15.00',
			$schema['offers']['price']
		);

		$this->assertSame(
			'USD',
			$schema['offers']['priceCurrency']
		);
	}

	/**
	 * Products without pricing should not generate offers.
	 */
	public function test_products_without_price_do_not_generate_offers(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			789,
			'No Price Product',
			'',
			'https://example.com/product/no-price-product/',
			'NO-PRICE-789',
			null,
			null,
			null,
			null,
			'https://schema.org/InStock',
			array()
		);

		$schema = $this->create_service()->generate(
			$product
		);

		$this->assertSame(
			'Product',
			$schema['@type']
		);

		$this->assertArrayNotHasKey(
			'offers',
			$schema
		);
	}

	/**
	 * Product schema should preserve basic product information.
	 */
	public function test_product_schema_preserves_product_information(): void {

		$schema = $this->create_service()->generate(
			$this->create_mesh_product_entry()
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

		$this->assertSame(
			'https://example.com/product/test-mesh-product/',
			$schema['mainEntityOfPage']['@id']
		);
	}

	/**
	 * Service should delegate mesh analysis to mesh schema service.
	 */
	public function test_delegates_mesh_analysis_to_mesh_schema_service(): void {

		$product = $this->create_mesh_product_entry();

		$mesh_result = new Shurloc_Mesh_Product_Result();

		$mesh_schema_service = $this->createMock(
			Shurloc_Mesh_Product_Schema_Service_Interface::class
		);

		$mesh_schema_service
		->expects( $this->once() )
		->method( 'analyze' )
		->with( $product )
		->willReturn( $mesh_result );

		$schema = $this->create_service(
			$mesh_schema_service
		)->generate(
			$product
		);

		$this->assertSame(
			'Product',
			$schema['@type']
		);
	}

	/**
	 * Service should enrich schema when mesh analysis returns a result.
	 */
	public function test_uses_mesh_analysis_result_when_available(): void {

		$product = $this->create_mesh_product_entry();

		$mesh_result = new Shurloc_Mesh_Product_Result();

		$mesh_schema_service = $this->createMock(
			Shurloc_Mesh_Product_Schema_Service_Interface::class
		);

		$mesh_schema_service
		->expects( $this->once() )
		->method( 'analyze' )
		->willReturn( $mesh_result );

		$schema = $this->create_service(
			$mesh_schema_service
		)->generate(
			$product
		);

		$this->assertIsArray(
			$schema
		);

		$this->assertSame(
			'Product',
			$schema['@type']
		);
	}

	/**
	 * Service should generate schema when mesh analysis returns null.
	 */
	public function test_generates_schema_when_mesh_analysis_returns_null(): void {

		$product = $this->create_mesh_product_entry();

		$mesh_schema_service = $this->createMock(
			Shurloc_Mesh_Product_Schema_Service_Interface::class
		);

		$mesh_schema_service
			->expects( $this->once() )
			->method( 'analyze' )
			->with( $product )
			->willReturn( null );

		$schema = $this->create_service(
			$mesh_schema_service
		)->generate(
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

		$this->assertArrayNotHasKey(
			'offers',
			$schema
		);
	}

	/**
	 * Create product schema service.
	 *
	 * @param Shurloc_Mesh_Product_Schema_Service_Interface|null $mesh_schema_service Mesh schema service.
	 * @return Shurloc_Product_Schema_Service
	 */
	private function create_service(
		?Shurloc_Mesh_Product_Schema_Service_Interface $mesh_schema_service = null
	): Shurloc_Product_Schema_Service {

		if ( null === $mesh_schema_service ) {

			$mesh_schema_service = new Shurloc_Mesh_Product_Schema_Service(
				new Shurloc_Mesh_Product_Analyzer(
					new Shurloc_Mesh_Parser()
				),
				new Shurloc_Product_Schema_Generator()
			);
		}

		return new Shurloc_Product_Schema_Service(
			new Shurloc_Product_Schema_Generator(),
			$mesh_schema_service
		);
	}

	/**
	 * Create mesh product fixture.
	 *
	 * @return Shurloc_Catalog_Product_Entry
	 */
	private function create_mesh_product_entry(): Shurloc_Catalog_Product_Entry {

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
					'110/80 Yellow $20.00',
					20.0,
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
			array()
		);
	}
}
