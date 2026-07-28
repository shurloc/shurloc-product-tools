<?php
/**
 * Tests for product schema integration.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests product schema integration.
 */
final class ShurlocProductSchemaIntegrationTest extends TestCase {

	/**
	 * Integration should generate and render product schema.
	 */
	public function test_renders_generated_product_schema(): void {

		$catalog_entry = $this->create_catalog_entry();

		$schema = array(
			'@context' => 'https://schema.org',
			'@type'    => 'Product',
			'name'     => 'Test Product',
		);

		$catalog_service = new Shurloc_Product_Catalog_Service_Double(
			product_entry: $catalog_entry,
		);

		$schema_service = new Shurloc_Product_Schema_Service_Double(
			schema: $schema,
		);

		$renderer = new Shurloc_Product_Schema_Renderer_Double();

		$integration = new Shurloc_Product_Schema_Integration(
			catalog_service: $catalog_service,
			schema_service: $schema_service,
			renderer: $renderer,
		);

		$integration->render_product_schema();

		$this->assertCount(
			1,
			$catalog_service->get_product_entry_calls()
		);

		$this->assertCount(
			1,
			$schema_service->get_calls()
		);

		$this->assertSame(
			$catalog_entry,
			$schema_service->get_calls()[0]
		);

		$this->assertCount(
			1,
			$renderer->get_calls()
		);

		$this->assertSame(
			$schema,
			$renderer->get_calls()[0]
		);
	}

	/**
	 * Integration should not render schema outside product pages.
	 */
	public function test_does_not_render_when_not_product_page(): void {

		$GLOBALS['shurloc_test_is_product'] = false;

		$catalog_service = $this->createMock(
			Shurloc_Product_Catalog_Service_Interface::class
		);

		$catalog_service
			->expects( $this->never() )
			->method( 'get_product_entry' );

		$schema_service = $this->createMock(
			Shurloc_Product_Schema_Service_Interface::class
		);

		$schema_service
			->expects( $this->never() )
			->method( 'generate' );

		$renderer = $this->createMock(
			Shurloc_Product_Schema_Renderer_Interface::class
		);

		$renderer
			->expects( $this->never() )
			->method( 'render' );

		$integration = new Shurloc_Product_Schema_Integration(
			$catalog_service,
			$schema_service,
			$renderer
		);

		$integration->render_product_schema();

		$GLOBALS['shurloc_test_is_product'] = true;
	}

	/**
	 * Integration should not render when catalog entry is unavailable.
	 */
	public function test_does_not_render_when_catalog_entry_is_null(): void {

		$catalog_service = $this->createMock(
			Shurloc_Product_Catalog_Service_Interface::class
		);

		$catalog_service
			->expects( $this->once() )
			->method( 'get_product_entry' )
			->willReturn( null );

		$schema_service = $this->createMock(
			Shurloc_Product_Schema_Service_Interface::class
		);

		$schema_service
			->expects( $this->never() )
			->method( 'generate' );

		$renderer = $this->createMock(
			Shurloc_Product_Schema_Renderer_Interface::class
		);

		$renderer
			->expects( $this->never() )
			->method( 'render' );

		$integration = new Shurloc_Product_Schema_Integration(
			$catalog_service,
			$schema_service,
			$renderer
		);

		$integration->render_product_schema();
	}

	/**
	 * Integration should not render when schema generation fails.
	 */
	public function test_does_not_render_when_schema_is_null(): void {

		$catalog_entry = $this->create_catalog_entry();

		$catalog_service = $this->createMock(
			Shurloc_Product_Catalog_Service_Interface::class
		);

		$catalog_service
			->expects( $this->once() )
			->method( 'get_product_entry' )
			->willReturn( $catalog_entry );

		$schema_service = $this->createMock(
			Shurloc_Product_Schema_Service_Interface::class
		);

		$schema_service
			->expects( $this->once() )
			->method( 'generate' )
			->with( $catalog_entry )
			->willReturn( null );

		$renderer = $this->createMock(
			Shurloc_Product_Schema_Renderer_Interface::class
		);

		$renderer
			->expects( $this->never() )
			->method( 'render' );

		$integration = new Shurloc_Product_Schema_Integration(
			$catalog_service,
			$schema_service,
			$renderer
		);

		$integration->render_product_schema();
	}

	/**
	 * Mesh products should render aggregate offer schema.
	 */
	public function test_mesh_product_outputs_aggregate_offer_schema(): void {

		$catalog_entry = new Shurloc_Catalog_Product_Entry(
			123,
			'Test Mesh Product',
			'',
			'https://example.com/product/test-mesh-product/',
			'TEST-MESH-123',
			'https://example.com/image.jpg',
			'Short product description.',
			'This is the long product description.',
			null,
			null,
			null,
			null,
			'https://schema.org/InStock',
			null,
			'Shur-loc®',
			null,
			array(),
			array(
				new Shurloc_Catalog_Variation_Entry(
					'110/80 Yellow $20.00',
					20.0,
					123,
					'Test Mesh Product',
					''
				),
				new Shurloc_Catalog_Variation_Entry(
					'160/64 White $25.00',
					25.0,
					123,
					'Test Mesh Product',
					''
				),
			)
		);

		$schema = array(
			'@context' => 'https://schema.org',
			'@type'    => 'Product',
			'name'     => 'Test Mesh Product',
			'offers'   => array(
				'@type'      => 'AggregateOffer',
				'lowPrice'   => '20.00',
				'highPrice'  => '25.00',
				'offerCount' => 2,
			),
		);

		$catalog_service = $this->createMock(
			Shurloc_Product_Catalog_Service_Interface::class
		);

		$catalog_service
		->expects( $this->once() )
		->method( 'get_product_entry' )
		->willReturn( $catalog_entry );

		$schema_service = $this->createMock(
			Shurloc_Product_Schema_Service_Interface::class
		);

		$schema_service
		->expects( $this->once() )
		->method( 'generate' )
		->with( $catalog_entry )
		->willReturn( $schema );

		$renderer = $this->createMock(
			Shurloc_Product_Schema_Renderer_Interface::class
		);

		$renderer
		->expects( $this->once() )
		->method( 'render' )
		->with( $schema );

		$integration = new Shurloc_Product_Schema_Integration(
			$catalog_service,
			$schema_service,
			$renderer
		);

		$integration->render_product_schema();
	}

	/**
	 * Non-mesh products should render standard offer schema.
	 */
	public function test_non_mesh_product_outputs_standard_offer_schema(): void {

		$catalog_entry = new Shurloc_Catalog_Product_Entry(
			456,
			'Non Mesh Product',
			'',
			'https://example.com/product/non-mesh-product/',
			'NON-MESH-456',
			'https://example.com/non-mesh-image.jpg',
			'Short description.',
			'Long product description.',
			null,
			15.0,
			15.0,
			null,
			'https://schema.org/InStock',
			null,
			'Shur-loc®',
			null,
			array(),
			array()
		);

		$schema = array(
			'@context' => 'https://schema.org',
			'@type'    => 'Product',
			'name'     => 'Non Mesh Product',
			'offers'   => array(
				'@type'         => 'Offer',
				'price'         => '15.00',
				'priceCurrency' => 'USD',
			),
		);

		$catalog_service = $this->createMock(
			Shurloc_Product_Catalog_Service_Interface::class
		);

		$catalog_service
		->expects( $this->once() )
		->method( 'get_product_entry' )
		->willReturn( $catalog_entry );

		$schema_service = $this->createMock(
			Shurloc_Product_Schema_Service_Interface::class
		);

		$schema_service
		->expects( $this->once() )
		->method( 'generate' )
		->with( $catalog_entry )
		->willReturn( $schema );

		$renderer = $this->createMock(
			Shurloc_Product_Schema_Renderer_Interface::class
		);

		$renderer
		->expects( $this->once() )
		->method( 'render' )
		->with( $schema );

		$integration = new Shurloc_Product_Schema_Integration(
			$catalog_service,
			$schema_service,
			$renderer
		);

		$integration->render_product_schema();
	}

	/**
	 * Create catalog product entry fixture.
	 *
	 * @return Shurloc_Catalog_Product_Entry
	 */
	private function create_catalog_entry(): Shurloc_Catalog_Product_Entry {

		return new Shurloc_Catalog_Product_Entry(
			product_id: 123,
			product_name: 'Test Product',
			edit_url: '',
			product_url: 'https://example.com/product/test-product/',
			sku: 'TEST-123',
			image_url: null,
			short_description: 'Short product description.',
			description: 'This is the product description.',
			category: null,
			price: null,
			regular_price: null,
			sale_price: null,
			availability: 'https://schema.org/InStock',
			brand: 'Shur-loc®',
			manufacturer: 'Shur-loc®',
			aggregate_rating: null,
			reviews: array(),
			variations: array(),
		);
	}
}
