<?php
/**
 * Tests for mesh product analysis results.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests mesh product result behavior.
 */
final class ShurlocMeshProductResultTest extends TestCase {

	/**
	 * Recognized mesh variations are stored and returned.
	 *
	 * @return void
	 */
	public function test_get_mesh_variations_returns_recognized_variations(): void {

		$entry = new Shurloc_Catalog_Variation_Entry(
			'110/80 White',
			12.99,
			1,
			'Test Mesh Product',
			''
		);

		$spec = new Shurloc_Mesh_Specification(
			110,
			80,
			'White'
		);

		$result = new Shurloc_Mesh_Product_Result();

		$result->add_mesh_variation(
			$entry,
			$spec
		);

		$variations = $result->get_mesh_variations();

		$this->assertCount(
			1,
			$variations
		);

		$this->assertSame(
			'110/80 White',
			$variations[0]['entry']->variation
		);

		$this->assertSame(
			$spec,
			$variations[0]['spec']
		);
	}

	/**
	 * Ignored variations are stored and returned.
	 *
	 * @return void
	 */
	public function test_get_ignored_variations_returns_ignored_entries(): void {

		$entry = new Shurloc_Catalog_Variation_Entry(
			'Thin Thread',
			0.0,
			1,
			'Test Mesh Product',
			''
		);

		$result = new Shurloc_Mesh_Product_Result();

		$result->add_ignored_variation(
			$entry
		);

		$variations = $result->get_ignored_variations();

		$this->assertCount(
			1,
			$variations
		);

		$this->assertSame(
			'Thin Thread',
			$variations[0]->variation
		);
	}

	/**
	 * Unrecognized variations are stored and returned.
	 *
	 * @return void
	 */
	public function test_get_unrecognized_variations_returns_entries(): void {

		$entry = new Shurloc_Catalog_Variation_Entry(
			'Something Unknown',
			10.00,
			1,
			'Test Mesh Product',
			''
		);

		$result = new Shurloc_Mesh_Product_Result();

		$result->add_unrecognized_variation(
			$entry
		);

		$variations = $result->get_unrecognized_variations();

		$this->assertCount(
			1,
			$variations
		);

		$this->assertSame(
			'Something Unknown',
			$variations[0]->variation
		);
	}

	/**
	 * Empty result returns empty arrays.
	 *
	 * @return void
	 */
	public function test_empty_result_returns_empty_arrays(): void {

		$result = new Shurloc_Mesh_Product_Result();

		$this->assertSame(
			array(),
			$result->get_mesh_variations()
		);

		$this->assertSame(
			array(),
			$result->get_ignored_variations()
		);

		$this->assertSame(
			array(),
			$result->get_unrecognized_variations()
		);
	}

	/**
	 * Result correctly identifies mesh products.
	 *
	 * @return void
	 */
	public function test_is_mesh_product_returns_true_when_mesh_variations_exist(): void {

		$entry = new Shurloc_Catalog_Variation_Entry(
			'110/80 White',
			12.99,
			1,
			'Test Mesh Product',
			''
		);

		$spec = new Shurloc_Mesh_Specification(
			110,
			80,
			'White'
		);

		$result = new Shurloc_Mesh_Product_Result();

		$result->add_mesh_variation(
			$entry,
			$spec
		);

		$this->assertTrue(
			$result->is_mesh_product()
		);
	}

	/**
	 * Empty result is not a mesh product.
	 *
	 * @return void
	 */
	public function test_is_mesh_product_returns_false_when_no_mesh_variations_exist(): void {

		$result = new Shurloc_Mesh_Product_Result();

		$this->assertFalse(
			$result->is_mesh_product()
		);
	}

	/**
	 * Mesh variation count returns correct value.
	 *
	 * @return void
	 */
	public function test_mesh_variation_count_returns_number_of_mesh_variations(): void {

		$result = new Shurloc_Mesh_Product_Result();

		$result->add_mesh_variation(
			new Shurloc_Catalog_Variation_Entry(
				'110/80 White',
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

		$result->add_mesh_variation(
			new Shurloc_Catalog_Variation_Entry(
				'160/64 Yellow',
				14.99,
				1,
				'Test Mesh Product',
				''
			),
			new Shurloc_Mesh_Specification(
				160,
				64,
				'Yellow'
			)
		);

		$this->assertSame(
			2,
			$result->mesh_variation_count()
		);
	}
}
