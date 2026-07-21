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
	 * Constructor.
	 *
	 * @param Shurloc_Mesh_Table_Row[] $rows Table rows.
	 */
	public function __construct(
		public readonly array $rows
	) {}

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
