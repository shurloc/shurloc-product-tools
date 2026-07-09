<?php
/**
 * Catalog analyzer.
 *
 * Analyzes a collection of WooCommerce variation names using the mesh parser.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Catalog analyzer.
 */
final class Shurloc_Catalog_Analyzer {

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
	 * Analyze a collection of variation names.
	 *
	 * Returns three collections:
	 *
	 * - recognized mesh specifications
	 * - unrecognized variation names
	 * - recognized but invalid mesh specifications
	 *
	 * @param string[] $variations Variation names.
	 * @return Shurloc_Catalog_Report
	 */
	public function analyze(
		array $variations
	): Shurloc_Catalog_Report {

		$report = new Shurloc_Catalog_Report();

		foreach ( $variations as $variation ) {

			$spec = $this->parser->parse( $variation );

			if ( ! $spec->recognized ) {
				$report->add_unrecognized_variation(
					$variation
				);
				continue;
			}

			$report->add_recognized_specification(
				$variation,
				$spec
			);

			if ( ! $spec->is_valid() ) {
				$report->add_invalid_specification(
					$variation,
					$spec
				);
			}
		}

		return $report;
	}
}
