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

		$catalog_entry = new Shurloc_Catalog_Product_Entry(
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
}
