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
	 * Renders recognized mesh variations.
	 *
	 * @return void
	 */
	public function test_renders_mesh_variations(): void {

		$result = new Shurloc_Mesh_Product_Result();

		$entry = new Shurloc_Catalog_Variation_Entry(
			'110/80 White',
			12.99,
			1,
			'Test Mesh Product',
			''
		);

		$spec = new Shurloc_Mesh_Specification();

		$spec->recognized      = true;
		$spec->mesh_count      = 110;
		$spec->thread_diameter = 80;
		$spec->color           = 'White';
		$spec->price_text      = '$12.99';

		$result->add_mesh_variation(
			$entry,
			$spec
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
