<?php
/**
 * Mesh product table shortcode interface.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product table shortcode interface.
 */
interface Shurloc_Mesh_Product_Table_Shortcode_Interface {

	/**
	 * Render the mesh product table.
	 *
	 * @param array<string,mixed> $attributes Shortcode attributes.
	 * @return string
	 */
	public function render(
		array $attributes = array()
	): string;
}
