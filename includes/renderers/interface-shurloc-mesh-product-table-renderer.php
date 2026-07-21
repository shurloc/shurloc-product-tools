<?php
/**
 * Mesh product table renderer interface.
 *
 * Defines customer-facing mesh table rendering behavior.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product table renderer interface.
 */
interface Shurloc_Mesh_Product_Table_Renderer_Interface {

	/**
	 * Render a mesh specification table.
	 *
	 * @param Shurloc_Mesh_Product_Result $result Mesh product analysis result.
	 * @return string HTML table.
	 */
	public function render(
		Shurloc_Mesh_Product_Result $result
	): string;
}
