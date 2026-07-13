<?php
/**
 * Mesh product analysis result.
 *
 * Represents the result of analyzing a WooCommerce product for mesh
 * variations.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product analysis result.
 */
final class Shurloc_Mesh_Product_Result {

	/**
	 * Recognized mesh variations.
	 *
	 * @var array<int, array{
	 *     entry: Shurloc_Catalog_Variation_Entry,
	 *     spec: Shurloc_Mesh_Specification
	 * }>
	 */
	public array $mesh_variations = array();

	/**
	 * Ignored variations.
	 *
	 * Examples:
	 * - Thin Thread separators.
	 * - Variations with no price.
	 *
	 * @var Shurloc_Catalog_Variation_Entry[]
	 */
	public array $ignored_variations = array();

	/**
	 * Unrecognized paid variations.
	 *
	 * These require attention because they are not recognized as mesh
	 * specifications but appear to be purchasable variations.
	 *
	 * @var Shurloc_Catalog_Variation_Entry[]
	 */
	public array $unrecognized_variations = array();

	/**
	 * Add a recognized mesh variation.
	 *
	 * @param Shurloc_Catalog_Variation_Entry $entry Catalog variation entry.
	 * @param Shurloc_Mesh_Specification      $spec Parsed mesh specification.
	 * @return void
	 */
	public function add_mesh_variation(
		Shurloc_Catalog_Variation_Entry $entry,
		Shurloc_Mesh_Specification $spec
	): void {

		$this->mesh_variations[] = array(
			'entry' => $entry,
			'spec'  => $spec,
		);
	}

	/**
	 * Add an ignored variation.
	 *
	 * @param Shurloc_Catalog_Variation_Entry $entry Catalog variation entry.
	 * @return void
	 */
	public function add_ignored_variation(
		Shurloc_Catalog_Variation_Entry $entry
	): void {

		$this->ignored_variations[] = $entry;
	}

	/**
	 * Add an unrecognized variation.
	 *
	 * @param Shurloc_Catalog_Variation_Entry $entry Catalog variation entry.
	 * @return void
	 */
	public function add_unrecognized_variation(
		Shurloc_Catalog_Variation_Entry $entry
	): void {

		$this->unrecognized_variations[] = $entry;
	}

	/**
	 * Determine whether this represents a mesh product.
	 *
	 * @return bool
	 */
	public function is_mesh_product(): bool {

		return ! empty( $this->mesh_variations );
	}
}
