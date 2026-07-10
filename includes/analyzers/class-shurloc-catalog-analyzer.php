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
	 * @param string[]      $variations        Variation names.
	 * @param callable|null $metadata_provider Optional metadata provider.
	 * @return Shurloc_Catalog_Report
	 */
	public function analyze(
		array $variations,
		?callable $metadata_provider = null
	): Shurloc_Catalog_Report {

		$report = new Shurloc_Catalog_Report();

		foreach ( $variations as $index => $variation ) {

			$metadata = array();

			if ( null !== $metadata_provider ) {
				$metadata = $metadata_provider( $index );
			}

			$spec = $this->parser->parse( $variation );

			if ( ! $spec->recognized ) {
				$report->add_unrecognized_variation(
					$variation,
					$metadata
				);
				continue;
			}

			$report->add_recognized_specification(
				$variation,
				$spec,
				$metadata
			);

			if ( ! $spec->is_valid() ) {
				$report->add_invalid_specification(
					$variation,
					$spec,
					$metadata
				);
			}
		}

		return $report;
	}
}
