<?php
/**
 * Tests for mesh table row DTO.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Mesh table row tests.
 */
final class ShurlocMeshTableRowTest extends TestCase {

	/**
	 * Constructor populates all properties.
	 *
	 * @return void
	 */
	public function test_constructor_populates_all_fields(): void {

		$row = new Shurloc_Mesh_Table_Row(
			110,
			80,
			'White',
			'S',
			'10 Pack',
			12.99,
			'110/80 S White $12.99'
		);

		$this->assertSame(
			110,
			$row->get_mesh_count()
		);

		$this->assertSame(
			80,
			$row->get_thread_diameter()
		);

		$this->assertSame(
			'White',
			$row->get_color()
		);

		$this->assertSame(
			'S',
			$row->get_modifier()
		);

		$this->assertSame(
			'10 Pack',
			$row->get_pack_size()
		);

		$this->assertSame(
			12.99,
			$row->get_price()
		);

		$this->assertSame(
			'110/80 S White $12.99',
			$row->get_variation_value()
		);
	}

	/**
	 * Nullable fields remain null.
	 *
	 * @return void
	 */
	public function test_nullable_fields_remain_null(): void {

		$row = new Shurloc_Mesh_Table_Row(
			230,
			40,
			'Yellow',
			null,
			null,
			null,
			'230/40 Yellow'
		);

		$this->assertSame(
			230,
			$row->get_mesh_count()
		);

		$this->assertSame(
			40,
			$row->get_thread_diameter()
		);

		$this->assertSame(
			'Yellow',
			$row->get_color()
		);

		$this->assertNull(
			$row->get_modifier()
		);

		$this->assertNull(
			$row->get_pack_size()
		);

		$this->assertNull(
			$row->get_price()
		);

		$this->assertSame(
			'230/40 Yellow',
			$row->get_variation_value()
		);
	}

	/**
	 * Returns variation value.
	 *
	 * @return void
	 */
	public function test_returns_variation_value(): void {

		$row = new Shurloc_Mesh_Table_Row(
			110,
			80,
			'Yellow',
			null,
			null,
			18.17,
			'110/80 Yellow $18.17'
		);

		$this->assertSame(
			'110/80 Yellow $18.17',
			$row->get_variation_value()
		);
	}


	/**
	 * Table rows permit a missing mesh color.
	 *
	 * @return void
	 */
	public function test_color_can_be_null(): void {

		$row = new Shurloc_Mesh_Table_Row(
			mesh_count: 120,
			thread_diameter: 48,
			color: null,
			modifier: 'S',
			pack_size: null,
			price: 24.10,
			variation_value: '120/48 (S) $24.10',
		);

		$this->assertNull(
			$row->get_color()
		);
	}
}
