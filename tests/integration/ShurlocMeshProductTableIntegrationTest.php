<?php
/**
 * Tests mesh product table shortcode integration.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests the complete mesh product table rendering flow.
 */
final class ShurlocMeshProductTableIntegrationTest extends TestCase {

	/**
	 * Clean up global state.
	 *
	 * @return void
	 */
	protected function tearDown(): void {

		unset( $GLOBALS['product'] );
		shurloc_reset_test_products();

		parent::tearDown();
	}


	/**
	 * Mesh products render a specification table.
	 *
	 * @return void
	 */
	public function test_mesh_product_renders_table_output(): void {

		$variation = new WC_Product( 101 );

		$variation->set_variation_attributes(
			array(
				'attribute_select-mesh-count' => '110/80 White',
			)
		);

		$variation->set_price(
			'12.99'
		);

		$product = new WC_Product( 1 );

		$product->set_name(
			'Test Mesh Product'
		);

		$product->set_type(
			'variable'
		);

		$product->set_children(
			array( 101 )
		);

		$GLOBALS['product'] = $product;

		$catalog_service = new Shurloc_Product_Catalog_Service();

		$analyzer = new Shurloc_Mesh_Product_Analyzer(
			new Shurloc_Mesh_Parser()
		);

		$data_service = new Shurloc_Mesh_Product_Data_Service(
			$catalog_service,
			$analyzer
		);

		$renderer = new Shurloc_Mesh_Product_Table_Renderer();

		$shortcode = new Shurloc_Mesh_Product_Table_Shortcode(
			$data_service,
			$renderer
		);

		$result = $data_service->analyze_product(
			$product
		);

		$this->assertTrue(
			$result->is_mesh_product()
		);

		$html = $shortcode->render();

		$this->assertStringContainsString(
			'<table',
			$html
		);

		$this->assertStringContainsString(
			'110',
			$html
		);

		$this->assertStringContainsString(
			'80',
			$html
		);

		$this->assertStringContainsString(
			'White',
			$html
		);

		$this->assertStringContainsString(
			'$12.99',
			$html
		);
	}
}
