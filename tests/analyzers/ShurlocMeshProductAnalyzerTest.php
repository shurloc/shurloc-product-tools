<?php
/**
 * Tests for Shurloc_Mesh_Product_Analyzer.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests mesh product analysis.
 */
final class ShurlocMeshProductAnalyzerTest extends TestCase {

	/**
	 * A product with recognized mesh variations should be identified as mesh.
	 */
	public function test_recognized_mesh_variations_make_product_a_mesh_product(): void {

		$entries = array(
			new Shurloc_Catalog_Variation_Entry(
				'110/80 Yellow $20.00',
				20.00,
				123,
				'Test Mesh Product',
				''
			),
			new Shurloc_Catalog_Variation_Entry(
				'160/64 White $25.00',
				25.00,
				123,
				'Test Mesh Product',
				''
			),
		);

		$analyzer = new Shurloc_Mesh_Product_Analyzer(
			new Shurloc_Mesh_Parser()
		);

		$result = $analyzer->analyze(
			$entries
		);

		$this->assertTrue(
			$result->is_mesh_product()
		);

		$this->assertCount(
			2,
			$result->mesh_variations
		);

		$this->assertCount(
			0,
			$result->ignored_variations
		);

		$this->assertCount(
			0,
			$result->unrecognized_variations
		);
	}


	/**
	 * Zero-price unrecognized variations should be ignored.
	 *
	 * This covers separators such as "Thin Thread".
	 */
	public function test_zero_price_unrecognized_variations_are_ignored(): void {

		$entries = array(
			new Shurloc_Catalog_Variation_Entry(
				'Thin Thread',
				0.0,
				123,
				'Test Mesh Product',
				''
			),
		);

		$analyzer = new Shurloc_Mesh_Product_Analyzer(
			new Shurloc_Mesh_Parser()
		);

		$result = $analyzer->analyze(
			$entries
		);

		$this->assertFalse(
			$result->is_mesh_product()
		);

		$this->assertCount(
			1,
			$result->ignored_variations
		);

		$this->assertCount(
			0,
			$result->unrecognized_variations
		);
	}


	/**
	 * Null-price unrecognized variations should be ignored.
	 */
	public function test_null_price_unrecognized_variations_are_ignored(): void {

		$entries = array(
			new Shurloc_Catalog_Variation_Entry(
				'Thin Thread',
				null,
				123,
				'Test Mesh Product',
				''
			),
		);

		$analyzer = new Shurloc_Mesh_Product_Analyzer(
			new Shurloc_Mesh_Parser()
		);

		$result = $analyzer->analyze(
			$entries
		);

		$this->assertCount(
			1,
			$result->ignored_variations
		);
	}


	/**
	 * Paid unrecognized variations should be reported.
	 */
	public function test_paid_unrecognized_variations_are_reported(): void {

		$entries = array(
			new Shurloc_Catalog_Variation_Entry(
				'Premium Orange',
				35.00,
				123,
				'Test Mesh Product',
				''
			),
		);

		$analyzer = new Shurloc_Mesh_Product_Analyzer(
			new Shurloc_Mesh_Parser()
		);

		$result = $analyzer->analyze(
			$entries
		);

		$this->assertFalse(
			$result->is_mesh_product()
		);

		$this->assertCount(
			1,
			$result->unrecognized_variations
		);
	}


	/**
	 * Recognized variations should retain parsed specification data.
	 */
	public function test_mesh_variations_include_parsed_specifications(): void {

		$entry = new Shurloc_Catalog_Variation_Entry(
			'110/80 Yellow $20.00',
			20.00,
			123,
			'Test Mesh Product',
			''
		);

		$analyzer = new Shurloc_Mesh_Product_Analyzer(
			new Shurloc_Mesh_Parser()
		);

		$result = $analyzer->analyze(
			array( $entry )
		);

		$this->assertSame(
			$entry,
			$result->mesh_variations[0]['entry']
		);

		$this->assertInstanceOf(
			Shurloc_Mesh_Specification::class,
			$result->mesh_variations[0]['spec']
		);
	}

	/**
	 * Recognized but invalid mesh specifications are still mesh products.
	 */
	public function test_invalid_mesh_specifications_are_mesh_products(): void {

		$entries = array(
			new Shurloc_Catalog_Variation_Entry(
				'350/30 Orange $35.00',
				35.00,
				123,
				'Test Mesh Product',
				''
			),
		);

		$analyzer = new Shurloc_Mesh_Product_Analyzer(
			new Shurloc_Mesh_Parser()
		);

		$result = $analyzer->analyze(
			$entries
		);

		$this->assertTrue(
			$result->is_mesh_product()
		);

		$this->assertCount(
			1,
			$result->mesh_variations
		);

		$this->assertFalse(
			$result->mesh_variations[0]['spec']->is_valid()
		);
	}
}
