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

		$product = $this->create_mesh_product(
			array(
				array(
					'id'    => 101,
					'value' => '110/80 White',
					'price' => '12.99',
				),
			)
		);

		$html = $this->render_mesh_table(
			$product
		);

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


	/**
	 * Mesh products without variations return empty output.
	 *
	 * @return void
	 */
	public function test_product_without_mesh_variations_returns_empty_output(): void {

		$product = new WC_Product( 1 );

		$product->set_name(
			'Empty Mesh Product'
		);

		$product->set_type(
			'variable'
		);

		$GLOBALS['product'] = $product;

		$html = $this->render_mesh_table(
			$product
		);

		$this->assertSame(
			'',
			$html
		);
	}


	/**
	 * Mesh products render multiple variation rows.
	 *
	 * @return void
	 */
	public function test_mesh_product_renders_multiple_variation_rows(): void {

		$product = $this->create_mesh_product(
			array(
				array(
					'id'    => 101,
					'value' => '110/80 White',
					'price' => '12.99',
				),
				array(
					'id'    => 102,
					'value' => '160/64 Yellow',
					'price' => '14.99',
				),
			)
		);

		$html = $this->render_mesh_table(
			$product
		);

		$this->assertStringContainsString(
			'110',
			$html
		);

		$this->assertStringContainsString(
			'160',
			$html
		);

		$this->assertStringContainsString(
			'White',
			$html
		);

		$this->assertStringContainsString(
			'Yellow',
			$html
		);

		$this->assertStringContainsString(
			'$12.99',
			$html
		);

		$this->assertStringContainsString(
			'$14.99',
			$html
		);
	}


	/**
	 * Create a mesh product test double.
	 *
	 * @param array<int,array{id:int,value:string,price:string}> $variations Variation data.
	 * @return WC_Product Product test double.
	 */
	private function create_mesh_product(
		array $variations
	): WC_Product {

		$children = array();

		foreach ( $variations as $variation_data ) {

			$variation = new WC_Product(
				$variation_data['id']
			);

			$variation->set_variation_attributes(
				array(
					'attribute_select-mesh-count' => $variation_data['value'],
				)
			);

			$variation->set_price(
				$variation_data['price']
			);

			$children[] = $variation_data['id'];
		}

		$product = new WC_Product( 1 );

		$product->set_name(
			'Test Mesh Product'
		);

		$product->set_type(
			'variable'
		);

		$product->set_children(
			$children
		);

		$GLOBALS['product'] = $product;

		return $product;
	}


	/**
	 * Render mesh table shortcode output.
	 *
	 * @param WC_Product $product Product to render.
	 * @return string Rendered HTML.
	 */
	private function render_mesh_table(
		WC_Product $product
	): string {

		$catalog_service = new Shurloc_Product_Catalog_Service();

		$analyzer = new Shurloc_Mesh_Product_Analyzer(
			new Shurloc_Mesh_Parser()
		);

		$data_service = new Shurloc_Mesh_Product_Data_Service(
			$catalog_service,
			$analyzer
		);

		$table_data_factory = new Shurloc_Mesh_Table_Data_Factory();

		$renderer = new Shurloc_Mesh_Product_Table_Renderer();

		$shortcode = new Shurloc_Mesh_Product_Table_Shortcode(
			$data_service,
			$table_data_factory,
			$renderer
		);

		return $shortcode->render();
	}

	/**
	 * Mesh table hides modifier column when no modifiers exist.
	 *
	 * @return void
	 */
	public function test_mesh_table_hides_modifier_column_when_no_modifiers_exist(): void {

		$product = $this->create_mesh_product(
			array(
				array(
					'id'    => 101,
					'value' => '110/80 White',
					'price' => '12.99',
				),
			)
		);

		$html = $this->render_mesh_table(
			$product
		);

		$this->assertStringNotContainsString(
			'<th>Modifier</th>',
			$html
		);
	}

	/**
	 * Mesh table hides pack size column when no pack sizes exist.
	 *
	 * @return void
	 */
	public function test_mesh_table_hides_pack_size_column_when_no_pack_sizes_exist(): void {

		$product = $this->create_mesh_product(
			array(
				array(
					'id'    => 101,
					'value' => '110/80 White',
					'price' => '12.99',
				),
			)
		);

		$html = $this->render_mesh_table(
			$product
		);

		$this->assertStringNotContainsString(
			'<th>Pack Size</th>',
			$html
		);
	}

	/**
	 * Mesh table shows optional columns when data exists.
	 *
	 * @return void
	 */
	public function test_mesh_table_shows_optional_columns_when_data_exists(): void {

		$product = $this->create_mesh_product(
			array(
				array(
					'id'    => 101,
					'value' => '10 Pack - 110/80 HD White',
					'price' => '12.99',
				),
			)
		);

		$html = $this->render_mesh_table(
			$product
		);

		$this->assertStringContainsString(
			'<th>Modifier</th>',
			$html
		);

		$this->assertStringContainsString(
			'<th>Pack Size</th>',
			$html
		);
	}
}
