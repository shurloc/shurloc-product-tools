<?php
/**
 * Mesh product analyzer.
 *
 * Analyzes WooCommerce product variation entries to determine whether a
 * product contains mesh specifications.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product analyzer.
 */
final class Shurloc_Mesh_Product_Analyzer implements Shurloc_Mesh_Product_Analyzer_Interface {

	/**
	 * Mesh parser.
	 *
	 * @var Shurloc_Mesh_Parser
	 */
	private Shurloc_Mesh_Parser $parser;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Mesh_Parser $parser Mesh parser.
	 */
	public function __construct(
		Shurloc_Mesh_Parser $parser
	) {

		$this->parser = $parser;
	}

	/**
	 * Analyze a collection of catalog variation entries.
	 *
	 * A product is considered a mesh product if at least one variation
	 * contains a recognized mesh specification.
	 *
	 * Variations that are not recognized and have no price (or a zero price)
	 * are ignored. These represent non-purchasable separators such as
	 * "Thin Thread".
	 *
	 * @param Shurloc_Catalog_Variation_Entry[] $entries Product variations.
	 * @return Shurloc_Mesh_Product_Result
	 */
	public function analyze(
		array $entries
	): Shurloc_Mesh_Product_Result {

		$result = new Shurloc_Mesh_Product_Result();

		foreach ( $entries as $entry ) {

			$spec = $this->parser->parse(
				$entry->variation
			);

			if ( $spec->recognized ) {

				$result->add_mesh_variation(
					$entry,
					$spec
				);

				continue;
			}

			if (
				null === $entry->price ||
				0.0 === $entry->price
			) {
				$result->add_ignored_variation(
					$entry
				);

				continue;
			}

			$result->add_unrecognized_variation(
				$entry
			);
		}

		return $result;
	}
}
