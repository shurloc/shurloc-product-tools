<?php
/**
 * Mesh table data factory.
 *
 * Converts mesh product analysis results into presentation-ready table data.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh table data factory.
 */
final class Shurloc_Mesh_Table_Data_Factory {

	/**
	 * Create table data from mesh product analysis results.
	 *
	 * @param Shurloc_Mesh_Product_Result $result Mesh product analysis result.
	 * @return Shurloc_Mesh_Table_Data Presentation-ready table data.
	 */
	public function create(
		Shurloc_Mesh_Product_Result $result
	): Shurloc_Mesh_Table_Data {

		$rows = array();

		$show_modifier_column  = false;
		$show_pack_size_column = false;

		foreach ( $result->get_mesh_variations() as $variation ) {

			$entry = $variation['entry'];
			$spec  = $variation['spec'];

			if ( null !== $spec->get_modifier() ) {

				$show_modifier_column = true;
			}

			if ( null !== $spec->get_pack_size() ) {

				$show_pack_size_column = true;
			}

			$rows[] = new Shurloc_Mesh_Table_Row(
				$spec->get_mesh_count(),
				$spec->get_thread_diameter(),
				$spec->get_color(),
				$spec->get_modifier(),
				$spec->get_pack_size(),
				$entry->price
			);
		}

		return new Shurloc_Mesh_Table_Data(
			$rows,
			$show_modifier_column,
			$show_pack_size_column
		);
	}
}
