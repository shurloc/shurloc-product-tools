<?php
/**
 * Tests for mesh product table shortcode.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests mesh product table shortcode.
 */
final class ShurlocMeshProductTableShortcodeTest extends TestCase {

	/**
	 * Mesh product table shortcode.
	 *
	 * @var Shurloc_Mesh_Product_Table_Shortcode
	 */
	private Shurloc_Mesh_Product_Table_Shortcode $shortcode;

	/**
	 * Renderer double.
	 *
	 * @var Shurloc_Mesh_Product_Table_Renderer_Double
	 */
	private Shurloc_Mesh_Product_Table_Renderer_Double $renderer;

	/**
	 * Mesh analysis result.
	 *
	 * @var Shurloc_Mesh_Product_Result
	 */
	private Shurloc_Mesh_Product_Result $result;

	/**
	 * Mesh product data service double.
	 *
	 * @var Shurloc_Mesh_Product_Data_Service_Double
	 */
	private Shurloc_Mesh_Product_Data_Service_Double $data_service;

	/**
	 * Mesh table data factory.
	 *
	 * @var Shurloc_Mesh_Table_Data_Factory
	 */
	private Shurloc_Mesh_Table_Data_Factory $table_data_factory;


	/**
	 * Set up test environment.
	 *
	 * @return void
	 */
	protected function setUp(): void {

		parent::setUp();

		$this->result = new Shurloc_Mesh_Product_Result();

		$this->data_service = new Shurloc_Mesh_Product_Data_Service_Double(
			$this->result
		);

		$this->table_data_factory = new Shurloc_Mesh_Table_Data_Factory();

		$this->renderer = new Shurloc_Mesh_Product_Table_Renderer_Double(
			'<table>Mesh Table</table>'
		);

		$this->shortcode = new Shurloc_Mesh_Product_Table_Shortcode(
			$this->data_service,
			$this->table_data_factory,
			$this->renderer
		);
	}


	/**
	 * Clean up test globals.
	 *
	 * @return void
	 */
	protected function tearDown(): void {

		unset( $GLOBALS['wp_shortcodes'] );
		unset( $GLOBALS['product'] );

		parent::tearDown();
	}


	/**
	 * Registers the shortcode.
	 *
	 * @return void
	 */
	public function test_register_adds_shortcode(): void {

		$this->shortcode->register();

		$this->assertArrayHasKey(
			'shurloc_mesh_table',
			$GLOBALS['wp_shortcodes']
		);
	}


	/**
	 * Returns an empty string when no product exists.
	 *
	 * @return void
	 */
	public function test_render_returns_empty_when_no_product_exists(): void {

		unset( $GLOBALS['product'] );

		$this->assertSame(
			'',
			$this->shortcode->render()
		);
	}


	/**
	 * Returns an empty string for non-mesh products.
	 *
	 * @return void
	 */
	public function test_render_returns_empty_for_non_mesh_product(): void {

		$GLOBALS['product'] = new WC_Product( 1 );

		$this->assertSame(
			'',
			$this->shortcode->render()
		);
	}


	/**
	 * Calls the renderer for mesh products.
	 *
	 * @return void
	 */
	public function test_render_returns_renderer_output(): void {

		$GLOBALS['product'] = new WC_Product( 1 );

		$this->result->add_mesh_variation(
			new Shurloc_Catalog_Variation_Entry(
				'110/80 White $12.99',
				12.99,
				1,
				'Test Product',
				''
			),
			new Shurloc_Mesh_Specification(
				'110/80 White $12.99',
				110,
				80,
				null,
				'White',
				null,
				'$12.99',
				true
			)
		);

		$html = $this->shortcode->render();

		$this->assertSame(
			'<table>Mesh Table</table>',
			$html
		);

		$this->assertCount(
			1,
			$this->renderer->get_calls()
		);
	}


	/**
	 * Passes table data to the renderer.
	 *
	 * @return void
	 */
	public function test_render_passes_table_data_to_renderer(): void {

		$GLOBALS['product'] = new WC_Product( 1 );

		$this->result->add_mesh_variation(
			new Shurloc_Catalog_Variation_Entry(
				'110/80 White $12.99',
				12.99,
				1,
				'Test Product',
				''
			),
			new Shurloc_Mesh_Specification(
				'110/80 White $12.99',
				110,
				80,
				null,
				'White',
				null,
				'$12.99',
				true
			)
		);

		$this->shortcode->render();

		$rendered_data = $this->renderer->get_calls()[0];

		$this->assertInstanceOf(
			Shurloc_Mesh_Table_Data::class,
			$rendered_data
		);

		$this->assertTrue(
			$rendered_data->has_rows()
		);

		$this->assertSame(
			1,
			$rendered_data->count()
		);
	}
}
