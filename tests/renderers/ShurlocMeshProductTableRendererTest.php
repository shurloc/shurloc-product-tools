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
	 * Set up renderer.
	 *
	 * @return void
	 */
	protected function setUp(): void {

		parent::setUp();

		$this->renderer = new Shurloc_Mesh_Product_Table_Renderer();
	}


	/**
	 * Create mesh specification fixture.
	 *
	 * @param array<string,mixed> $values Specification overrides.
	 * @return Shurloc_Mesh_Specification Mesh specification.
	 */
	private function create_mesh_specification(
		array $values = array()
	): Shurloc_Mesh_Specification {

		$defaults = array(
			'raw'             => '110/80 White $12.99',
			'mesh_count'      => 110,
			'thread_diameter' => 80,
			'modifier'        => null,
			'color'           => 'White',
			'pack_size'       => null,
			'price_text'      => '$12.99',
			'recognized'      => true,
			'unknown_tokens'  => array(),
		);

		$values = array_merge(
			$defaults,
			$values
		);

		return new Shurloc_Mesh_Specification(
			$values['raw'],
			$values['mesh_count'],
			$values['thread_diameter'],
			$values['modifier'],
			$values['color'],
			$values['pack_size'],
			$values['price_text'],
			$values['recognized'],
			$values['unknown_tokens']
		);
	}


	/**
	 * Renders recognized mesh variations.
	 *
	 * @return void
	 */
	public function test_renders_mesh_variations(): void {

		$result = new Shurloc_Mesh_Product_Result();

		$entry = new Shurloc_Catalog_Variation_Entry(
			'110/80 White $12.99',
			12.99,
			1,
			'Test Mesh Product',
			''
		);

		$result->add_mesh_variation(
			$entry,
			$this->create_mesh_specification()
		);

		$html = $this->renderer->render(
			$result
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
			'$12.99',
			$html
		);
	}


	/**
	 * Renders modifier column when modifier exists.
	 *
	 * @return void
	 */
	public function test_renders_modifier_column(): void {

		$result = new Shurloc_Mesh_Product_Result();

		$entry = new Shurloc_Catalog_Variation_Entry(
			'110/80 White $12.99',
			12.99,
			1,
			'Test Mesh Product',
			''
		);

		$result->add_mesh_variation(
			$entry,
			$this->create_mesh_specification(
				array(
					'modifier' => 'S',
					'color'    => 'Yellow',
				)
			)
		);

		$html = $this->renderer->render(
			$result
		);

		$this->assertStringContainsString(
			'Modifier',
			$html
		);

		$this->assertStringContainsString(
			'S',
			$html
		);
	}


	/**
	 * Renders multiple mesh variations.
	 *
	 * @return void
	 */
	public function test_renders_multiple_mesh_variations(): void {

		$result = new Shurloc_Mesh_Product_Result();

		$result->add_mesh_variation(
			new Shurloc_Catalog_Variation_Entry(
				'110/80 White $12.99',
				12.99,
				1,
				'Test Mesh Product',
				''
			),
			$this->create_mesh_specification()
		);

		$result->add_mesh_variation(
			new Shurloc_Catalog_Variation_Entry(
				'160/64 Yellow $15.99',
				15.99,
				1,
				'Test Product',
				''
			),
			$this->create_mesh_specification(
				array(
					'raw'             => '160/64 Yellow $15.99',
					'mesh_count'      => 160,
					'thread_diameter' => 64,
					'color'           => 'Yellow',
					'price_text'      => '$15.99',
				)
			)
		);

		$html = $this->renderer->render(
			$result
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
			'Yellow',
			$html
		);
	}


	/**
	 * Does not render when no mesh variations exist.
	 *
	 * @return void
	 */
	public function test_returns_empty_string_without_mesh_variations(): void {

		$result = new Shurloc_Mesh_Product_Result();

		$html = $this->renderer->render(
			$result
		);

		$this->assertSame(
			'',
			$html
		);
	}
}
