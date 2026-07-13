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
	 * Analyze a collection of catalog variation entries.
	 *
	 * Returns three collections:
	 *
	 * - recognized mesh specifications
	 * - unrecognized variations
	 * - recognized but invalid mesh specifications
	 *
	 * @param Shurloc_Catalog_Variation_Entry[] $entries Catalog variation entries.
	 * @return Shurloc_Catalog_Report
	 */
	public function analyze(
		array $entries
	): Shurloc_Catalog_Report {

		$report = new Shurloc_Catalog_Report();

		foreach ( $entries as $entry ) {

			$spec = $this->parser->parse(
				$entry->variation
			);

			$metadata = $entry->to_array();

			if ( ! $spec->recognized ) {
				$report->add_unrecognized_variation(
					$entry->variation,
					$metadata
				);
				continue;
			}

			$report->add_recognized_specification(
				$entry->variation,
				$spec,
				$metadata
			);

			if ( ! $spec->is_valid() ) {
				$report->add_invalid_specification(
					$entry->variation,
					$spec,
					$metadata
				);
			}
		}

		return $report;
	}
}
