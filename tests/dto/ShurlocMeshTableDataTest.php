<?php
/**
 * Tests for mesh table data DTO.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Mesh table data tests.
 */
final class ShurlocMeshTableDataTest extends TestCase {

	/**
	 * Empty table data contains no rows.
	 *
	 * @return void
	 */
	public function test_empty_table_data_has_no_rows(): void {

		$data = new Shurloc_Mesh_Table_Data(
			array(),
			false,
			false
		);

		$this->assertFalse(
			$data->has_rows()
		);

		$this->assertSame(
			0,
			$data->count()
		);

		$this->assertSame(
			array(),
			$data->get_rows()
		);
	}

	/**
	 * Table data returns supplied rows.
	 *
	 * @return void
	 */
	public function test_table_data_returns_rows(): void {

		$row = new Shurloc_Mesh_Table_Row(
			110,
			80,
			'White',
			null,
			'10 Pack',
			12.99
		);

		$data = new Shurloc_Mesh_Table_Data(
			array(
				$row,
			),
			false,
			true
		);

		$this->assertTrue(
			$data->has_rows()
		);

		$this->assertSame(
			1,
			$data->count()
		);

		$this->assertSame(
			array(
				$row,
			),
			$data->get_rows()
		);
	}

	/**
	 * Multiple rows are preserved in order.
	 *
	 * @return void
	 */
	public function test_multiple_rows_are_preserved_in_order(): void {

		$first_row = new Shurloc_Mesh_Table_Row(
			110,
			80,
			'White',
			null,
			'10 Pack',
			12.99
		);

		$second_row = new Shurloc_Mesh_Table_Row(
			160,
			64,
			'Yellow',
			'HD',
			'20 Pack',
			25.00
		);

		$data = new Shurloc_Mesh_Table_Data(
			array(
				$first_row,
				$second_row,
			),
			true,
			true
		);

		$rows = $data->get_rows();

		$this->assertCount(
			2,
			$rows
		);

		$this->assertSame(
			$first_row,
			$rows[0]
		);

		$this->assertSame(
			$second_row,
			$rows[1]
		);
	}

	/**
	 * Row count matches supplied row collection.
	 *
	 * @return void
	 */
	public function test_count_returns_number_of_rows(): void {

		$data = new Shurloc_Mesh_Table_Data(
			array(
				new Shurloc_Mesh_Table_Row(
					110,
					80,
					'White',
					null,
					null,
					12.99
				),
				new Shurloc_Mesh_Table_Row(
					160,
					64,
					'Yellow',
					null,
					null,
					15.99
				),
				new Shurloc_Mesh_Table_Row(
					230,
					48,
					'White',
					'S',
					null,
					18.99
				),
			),
			true,
			false
		);

		$this->assertSame(
			3,
			$data->count()
		);
	}
}
