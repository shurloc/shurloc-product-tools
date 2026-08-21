<?php
/**
 * Mesh product table renderer interface.
 *
 * @package ShurlocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product table renderer interface.
 */
interface Shurloc_Mesh_Product_Table_Renderer_Interface {

	/**
	 * Render mesh specification table.
	 *
	 * @param Shurloc_Mesh_Table_Data $data Table data.
	 * @return string HTML output.
	 */
	public function render(
		Shurloc_Mesh_Table_Data $data
	): string;
}
