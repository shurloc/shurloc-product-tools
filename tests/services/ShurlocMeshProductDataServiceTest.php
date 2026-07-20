<?php
/**
 * Tests for mesh product data service.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests mesh product data service behavior.
 */
final class ShurlocMeshProductDataServiceTest extends TestCase {

	/**
	 * Mesh product data service.
	 *
	 * @var Shurloc_Mesh_Product_Data_Service
	 */
	private Shurloc_Mesh_Product_Data_Service $service;

	/**
	 * Analysis result used by the analyzer double.
	 *
	 * @var Shurloc_Mesh_Product_Result
	 */
	private Shurloc_Mesh_Product_Result $result;

	/**
	 * Analyzer double.
	 *
	 * @var Shurloc_Mesh_Product_Analyzer_Double
	 */
	private Shurloc_Mesh_Product_Analyzer_Double $analyzer;

	/**
	 * Set up test environment.
	 *
	 * @return void
	 */
	protected function setUp(): void {

		parent::setUp();

		$this->result = new Shurloc_Mesh_Product_Result();

		$entry = new Shurloc_Catalog_Variation_Entry(
			'110/80 White ($12.99)',
			12.99,
			1,
			'Test Mesh Product',
			''
		);

		$catalog_service = new Shurloc_Product_Catalog_Service_Double(
			array( $entry )
		);

		$this->analyzer = new Shurloc_Mesh_Product_Analyzer_Double(
			$this->result
		);

		$this->service = new Shurloc_Mesh_Product_Data_Service(
			$catalog_service,
			$this->analyzer
		);
	}

	/**
	 * Analyze product returns mesh product result.
	 *
	 * @return void
	 */
	public function test_analyze_product_returns_analysis_result(): void {

		$product = new WC_Product( 1 );

		$result = $this->service->analyze_product(
			$product
		);

		$this->assertSame(
			$this->result,
			$result
		);
	}

	/**
	 * Mesh product detection returns true when analyzer identifies mesh.
	 *
	 * @return void
	 */
	public function test_is_mesh_product_returns_true_for_mesh_product(): void {

		$this->result->add_mesh_variation(
			new Shurloc_Catalog_Variation_Entry(
				'110/80 White ($12.99)',
				12.99,
				1,
				'Test Mesh Product',
				''
			),
			new Shurloc_Mesh_Specification(
				110,
				80,
				'White'
			)
		);

		$product = new WC_Product( 1 );

		$this->assertTrue(
			$this->service->is_mesh_product(
				$product
			)
		);
	}

	/**
	 * Mesh product detection returns false when analyzer finds no mesh.
	 *
	 * @return void
	 */
	public function test_is_mesh_product_returns_false_for_non_mesh_product(): void {

		$product = new WC_Product( 1 );

		$this->assertFalse(
			$this->service->is_mesh_product(
				$product
			)
		);
	}

	/**
	 * Catalog variations are passed to the analyzer.
	 *
	 * @return void
	 */
	public function test_analyze_product_passes_catalog_variations_to_analyzer(): void {

		$product = new WC_Product(
			1
		);

		$this->service->analyze_product(
			$product
		);

		$entries = $this->analyzer->get_entries();

		$this->assertCount(
			1,
			$entries
		);

		$this->assertSame(
			'110/80 White ($12.99)',
			$entries[0]->variation
		);

		$this->assertSame(
			12.99,
			$entries[0]->price
		);
	}
}
