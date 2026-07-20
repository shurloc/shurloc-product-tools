<?php
/**
 * Mesh product analyzer interface.
 *
 * Defines mesh product analysis behavior.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product analyzer contract.
 */
interface Shurloc_Mesh_Product_Analyzer_Interface {

	/**
	 * Analyze catalog variation entries.
	 *
	 * Determines recognized, ignored, and unrecognized mesh variations.
	 *
	 * @param Shurloc_Catalog_Variation_Entry[] $entries Catalog entries.
	 * @return Shurloc_Mesh_Product_Result Analysis result.
	 */
	public function analyze(
		array $entries
	): Shurloc_Mesh_Product_Result;
}
