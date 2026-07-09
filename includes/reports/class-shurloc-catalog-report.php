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

	/**
	 * Return the total number of variations analyzed.
	 *
	 * @return int
	 */
	public function total_variations(): int {

		return (
			$this->recognized_specification_count() +
			$this->unrecognized_variation_count()
		);
	}

	/**
	 * Return the number of recognized mesh specifications.
	 *
	 * @return int
	 */
	public function recognized_specification_count(): int {

		return count( $this->recognized_specifications );
	}

	/**
	 * Return the number of unrecognized variation names.
	 *
	 * @return int
	 */
	public function unrecognized_variation_count(): int {

		return count( $this->unrecognized_variations );
	}

	/**
	 * Return the number of invalid mesh specifications.
	 *
	 * @return int
	 */
	public function invalid_specification_count(): int {

		return count( $this->invalid_specifications );
	}

	/**
	 * Return a summary of the catalog analysis.
	 *
	 * @return array{
	 *     total_variations: int,
	 *     recognized_specifications: int,
	 *     unrecognized_variations: int,
	 *     invalid_specifications: int
	 * }
	 */
	public function summary(): array {

		return array(
			'total_variations'          => $this->total_variations(),
			'recognized_specifications' => $this->recognized_specification_count(),
			'unrecognized_variations'   => $this->unrecognized_variation_count(),
			'invalid_specifications'    => $this->invalid_specification_count(),
		);
	}

	/**
	 * Return the report as an associative array.
	 *
	 * @return array{
	 *     summary: array{
	 *         total_variations: int,
	 *         recognized_specifications: int,
	 *         unrecognized_variations: int,
	 *         invalid_specifications: int
	 *     },
	 *     recognized_specifications: array<int, array{
	 *         variation: string,
	 *         spec: array{
	 *             raw: string,
	 *             mesh_count: int|null,
	 *             thread_diameter: int|null,
	 *             modifier: string|null,
	 *             color: string|null,
	 *             pack_size: string|null,
	 *             price_text: string|null,
	 *             recognized: bool,
	 *             unknown_tokens: string[]
	 *         }
	 *     }>,
	 *     unrecognized_variations: string[],
	 *     invalid_specifications: array<int, array{
	 *         variation: string,
	 *         spec: array{
	 *             raw: string,
	 *             mesh_count: int|null,
	 *             thread_diameter: int|null,
	 *             modifier: string|null,
	 *             color: string|null,
	 *             pack_size: string|null,
	 *             price_text: string|null,
	 *             recognized: bool,
	 *             unknown_tokens: string[]
	 *         }
	 *     }>
	 * }
	 */
	public function to_array(): array {

		$recognized = array();

		foreach ( $this->recognized_specifications as $entry ) {

			$recognized[] = array(
				'variation' => $entry['variation'],
				'spec'      => $entry['spec']->to_array(),
			);
		}

		$invalid = array();

		foreach ( $this->invalid_specifications as $entry ) {

			$invalid[] = array(
				'variation' => $entry['variation'],
				'spec'      => $entry['spec']->to_array(),
			);
		}

		return array(
			'summary'                   => $this->summary(),
			'recognized_specifications' => $recognized,
			'unrecognized_variations'   => $this->unrecognized_variations,
			'invalid_specifications'    => $invalid,
		);
	}
}
