<?php
/**
 * Mesh table data DTO.
 *
 * Represents presentation-ready mesh table data.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh table data DTO.
 */
final class Shurloc_Mesh_Table_Data {

	/**
	 * Table rows.
	 *
	 * @var Shurloc_Mesh_Table_Row[]
	 */
	private readonly array $rows;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Mesh_Table_Row[] $rows Table rows.
	 */
	public function __construct(
		array $rows
	) {

		$this->rows = $rows;
	}

	/**
	 * Get table rows.
	 *
	 * @return Shurloc_Mesh_Table_Row[] Table rows.
	 */
	public function get_rows(): array {

		return $this->rows;
	}

	/**
	 * Determine whether the table contains rows.
	 *
	 * @return bool True when rows exist.
	 */
	public function has_rows(): bool {

		return ! empty( $this->rows );
	}

	/**
	 * Get row count.
	 *
	 * @return int Number of rows.
	 */
	public function count(): int {

		return count( $this->rows );
	}
}
