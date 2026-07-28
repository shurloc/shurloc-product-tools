<?php
/**
 * Tests for mesh product table renderer.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests mesh table rendering.
 */
final class ShurlocMeshProductTableRendererTest extends TestCase {

	/**
	 * Renderer.
	 *
	 * @var Shurloc_Mesh_Product_Table_Renderer
	 */
	private Shurloc_Mesh_Product_Table_Renderer $renderer;

	/**
	 * Table data factory.
	 *
	 * @var Shurloc_Mesh_Table_Data_Factory
	 */
	private Shurloc_Mesh_Table_Data_Factory $factory;


	/**
	 * Set up renderer.
	 */
	protected function setUp(): void {

		parent::setUp();

		$this->renderer = new Shurloc_Mesh_Product_Table_Renderer();

		$this->factory = new Shurloc_Mesh_Table_Data_Factory();
	}


	/**
	 * Create table data fixture.
	 *
	 * @param Shurloc_Mesh_Table_Row[] $rows Table rows.
	 * @return Shurloc_Mesh_Table_Data Table data.
	 */
	private function create_table_data(
		array $rows
	): Shurloc_Mesh_Table_Data {

		$has_modifier  = false;
		$has_pack_size = false;

		foreach ( $rows as $row ) {

			if ( null !== $row->get_modifier() ) {
				$has_modifier = true;
			}

			if ( null !== $row->get_pack_size() ) {
				$has_pack_size = true;
			}
		}

		return new Shurloc_Mesh_Table_Data(
			rows: $rows,
			show_modifier_column: $has_modifier,
			show_pack_size_column: $has_pack_size,
		);
	}


	/**
	 * Renders recognized mesh variations.
	 */
	public function test_renders_mesh_variations(): void {

		$data = $this->create_table_data(
			rows: array(
				new Shurloc_Mesh_Table_Row(
					mesh_count: 110,
					thread_diameter: 80,
					color: 'White',
					modifier: null,
					pack_size: '10 Pack',
					price: 12.99,
					variation_value: '110/80 White $12.99',
				),
			),
		);

		$html = $this->renderer->render(
			data: $data,
		);

		$this->assertStringContainsString(
			'shurloc-mesh-specification-table',
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
			'Pack Size',
			$html
		);

		$this->assertStringContainsString(
			'10 Pack',
			$html
		);

		$this->assertStringContainsString(
			'$12.99',
			$html
		);
	}


	/**
	 * Hides modifier column when no modifiers exist.
	 */
	public function test_hides_modifier_column_when_no_modifiers_exist(): void {

		$data = $this->create_table_data(
			rows: array(
				new Shurloc_Mesh_Table_Row(
					mesh_count: 110,
					thread_diameter: 80,
					color: 'White',
					modifier: null,
					pack_size: '10 Pack',
					price: 12.99,
					variation_value: '110/80 White $12.99',
				),
			),
		);

		$html = $this->renderer->render(
			data: $data,
		);

		$this->assertStringNotContainsString(
			'<th>Modifier</th>',
			$html
		);
	}


	/**
	 * Hides pack size column when no pack sizes exist.
	 */
	public function test_hides_pack_size_column_when_no_pack_sizes_exist(): void {

		$data = $this->create_table_data(
			rows: array(
				new Shurloc_Mesh_Table_Row(
					mesh_count: 110,
					thread_diameter: 80,
					color: 'White',
					modifier: null,
					pack_size: null,
					price: 12.99,
					variation_value: '110/80 White $12.99',
				),
			),
		);

		$html = $this->renderer->render(
			data: $data,
		);

		$this->assertStringNotContainsString(
			'<th>Pack Size</th>',
			$html
		);
	}


	/**
	 * Shows modifier column when modifiers exist.
	 */
	public function test_shows_modifier_column_when_modifier_exists(): void {

		$data = $this->create_table_data(
			rows: array(
				new Shurloc_Mesh_Table_Row(
					mesh_count: 110,
					thread_diameter: 80,
					color: 'White',
					modifier: 'HD',
					pack_size: null,
					price: 12.99,
					variation_value: '110/80 HD White $12.99',
				),
			),
		);

		$html = $this->renderer->render(
			data: $data,
		);

		$this->assertStringContainsString(
			'class="shurloc-mesh-table-modifier"',
			$html
		);

		$this->assertStringContainsString(
			'HD',
			$html
		);
	}


	/**
	 * Shows pack size column when pack sizes exist.
	 */
	public function test_shows_pack_size_column_when_pack_size_exists(): void {

		$data = $this->create_table_data(
			rows: array(
				new Shurloc_Mesh_Table_Row(
					mesh_count: 110,
					thread_diameter: 80,
					color: 'White',
					modifier: null,
					pack_size: '10 Pack',
					price: 12.99,
					variation_value: '110/80 White $12.99',
				),
			),
		);

		$html = $this->renderer->render(
			data: $data,
		);

		$this->assertStringContainsString(
			'class="shurloc-mesh-table-pack-size"',
			$html
		);

		$this->assertStringContainsString(
			'10 Pack',
			$html
		);
	}


	/**
	 * Maintains expected column order.
	 */
	public function test_renders_columns_in_expected_order(): void {

		$data = $this->create_table_data(
			rows: array(
				new Shurloc_Mesh_Table_Row(
					mesh_count: 110,
					thread_diameter: 80,
					color: 'White',
					modifier: 'HD',
					pack_size: '10 Pack',
					price: 12.99,
					variation_value: '110/80 HD White $12.99',
				),
			),
		);

		$html = $this->renderer->render(
			data: $data,
		);

		$mesh_position = strpos(
			$html,
			'class="shurloc-mesh-table-mesh"'
		);

		$thread_position = strpos(
			$html,
			'class="shurloc-mesh-table-thread"'
		);

		$modifier_position = strpos(
			$html,
			'class="shurloc-mesh-table-modifier"'
		);

		$color_position = strpos(
			$html,
			'class="shurloc-mesh-table-color"'
		);

		$pack_position = strpos(
			$html,
			'class="shurloc-mesh-table-pack-size"'
		);

		$price_position = strpos(
			$html,
			'class="shurloc-mesh-table-price"'
		);

		$this->assertLessThan(
			$thread_position,
			$mesh_position
		);

		$this->assertLessThan(
			$modifier_position,
			$thread_position
		);

		$this->assertLessThan(
			$color_position,
			$modifier_position
		);

		$this->assertLessThan(
			$pack_position,
			$color_position
		);

		$this->assertLessThan(
			$price_position,
			$pack_position
		);
	}

	/**
	 * Renders row without color.
	 */
	public function test_renders_row_without_color(): void {

		$data = $this->create_table_data(
			rows: array(
				new Shurloc_Mesh_Table_Row(
					mesh_count: 120,
					thread_diameter: 48,
					color: null,
					modifier: 'S',
					pack_size: null,
					price: 24.10,
					variation_value: '120/48 (S) $24.10',
				),
			),
		);

		$html = $this->renderer->render(
			data: $data,
		);

		$this->assertStringContainsString(
			'class="shurloc-mesh-table-color"',
			$html
		);

		$this->assertStringContainsString(
			'120',
			$html
		);

		$this->assertStringContainsString(
			'48',
			$html
		);

		$this->assertStringContainsString(
			'S',
			$html
		);

		$this->assertStringContainsString(
			'$24.10',
			$html
		);

		$this->assertStringContainsString(
			'—',
			$html
		);
	}
}
