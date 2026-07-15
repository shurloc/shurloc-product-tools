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
	 *
	 * @return void
	 */
	public function test_renders_generated_product_schema(): void {

		$catalog_entry = $this->create_catalog_entry();

		$schema = array(
			'@context' => 'https://schema.org',
			'@type'    => 'Product',
			'name'     => 'Test Product',
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
	 * Integration should not render schema outside product pages.
	 *
	 * @return void
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
	 *
	 * @return void
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
	 *
	 * @return void
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
	 * Create catalog product entry fixture.
	 *
	 * @return Shurloc_Catalog_Product_Entry
	 */
	private function create_catalog_entry(): Shurloc_Catalog_Product_Entry {

		return new Shurloc_Catalog_Product_Entry(
			123,
			'Test Product',
			'',
			'https://example.com/product/test-product/',
			'TEST-123',
			null,
			null,
			null,
			null,
			'https://schema.org/InStock',
			array()
		);
	}
}
