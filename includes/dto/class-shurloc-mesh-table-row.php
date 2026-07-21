<?php
/**
 * Mesh table row DTO.
 *
 * Represents a single presentation-ready row for the mesh product table.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh table row DTO.
 */
final class Shurloc_Mesh_Table_Row {

	/**
	 * Constructor.
	 *
	 * @param int         $mesh_count      Mesh count.
	 * @param int         $thread_diameter Thread diameter.
	 * @param string      $color           Mesh color.
	 * @param string|null $modifier        Mesh modifier.
	 * @param string|null $pack_size       Pack size.
	 * @param float|null  $price           Variation price.
	 */
	public function __construct(
		public readonly int $mesh_count,
		public readonly int $thread_diameter,
		public readonly string $color,
		public readonly ?string $modifier,
		public readonly ?string $pack_size,
		public readonly ?float $price
	) {}
}
