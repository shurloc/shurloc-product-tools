<?php
/**
 * Mesh product analyzer test double.
 *
 * Provides a controllable implementation of the mesh product analyzer
 * interface for unit testing services that depend on mesh analysis.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product analyzer test double.
 */
final class Shurloc_Mesh_Product_Analyzer_Double implements Shurloc_Mesh_Product_Analyzer_Interface {

	/**
	 * Analysis result to return.
	 *
	 * @var Shurloc_Mesh_Product_Result
	 */
	private Shurloc_Mesh_Product_Result $result;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Mesh_Product_Result $result Analysis result to return.
	 */
	public function __construct(
		Shurloc_Mesh_Product_Result $result
	) {

		$this->result = $result;
	}

	/**
	 * Analyze catalog variation entries.
	 *
	 * Returns the predefined result supplied during construction.
	 * This allows dependent services to be tested without invoking the
	 * mesh parser or analyzer logic.
	 *
	 * @param Shurloc_Catalog_Variation_Entry[] $entries Catalog entries.
	 * @return Shurloc_Mesh_Product_Result Analysis result.
	 */
	public function analyze(
		array $entries
	): Shurloc_Mesh_Product_Result {

		return $this->result;
	}
}
