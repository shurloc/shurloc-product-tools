<?php
/**
 * Catalog analysis report.
 *
 * Stores the results of analyzing a collection of WooCommerce variation
 * names.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Catalog analysis report.
 */
final class Shurloc_Catalog_Report {

	/**
	 * Recognized mesh specifications.
	 *
	 * Each entry contains the original variation name and its parsed
	 * specification.
	 *
	 * @var array<int, array{
	 *     variation: string,
	 *     spec: Shurloc_Mesh_Specification
	 * }>
	 */
	public array $recognized_specifications = array();

	/**
	 * Unrecognized variation names.
	 *
	 * These variation names were not identified as mesh specifications.
	 *
	 * @var string[]
	 */
	public array $unrecognized_variations = array();

	/**
	 * Invalid mesh specifications.
	 *
	 * These variation names were recognized as mesh specifications but did
	 * not parse into a valid specification.
	 *
	 * Each entry contains the original variation name and its parsed
	 * specification.
	 *
	 * @var array<int, array{
	 *     variation: string,
	 *     spec: Shurloc_Mesh_Specification
	 * }>
	 */
	public array $invalid_specifications = array();

	/**
	 * Add a recognized mesh specification.
	 *
	 * @param string                     $variation Variation name.
	 * @param Shurloc_Mesh_Specification $spec      Parsed specification.
	 * @return void
	 */
	public function add_recognized_specification(
		string $variation,
		Shurloc_Mesh_Specification $spec
	): void {

		$this->recognized_specifications[] = array(
			'variation' => $variation,
			'spec'      => $spec,
		);
	}

	/**
	 * Add an unrecognized variation name.
	 *
	 * @param string $variation Variation name.
	 * @return void
	 */
	public function add_unrecognized_variation(
		string $variation
	): void {

		$this->unrecognized_variations[] = $variation;
	}

	/**
	 * Add an invalid mesh specification.
	 *
	 * @param string                     $variation Variation name.
	 * @param Shurloc_Mesh_Specification $spec      Parsed specification.
	 * @return void
	 */
	public function add_invalid_specification(
		string $variation,
		Shurloc_Mesh_Specification $spec
	): void {

		$this->invalid_specifications[] = array(
			'variation' => $variation,
			'spec'      => $spec,
		);
	}
}
