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
	 * @return array{
	 *     recognized: array<int, array{
	 *         variation: string,
	 *         spec: Shurloc_Mesh_Specification
	 *     }>,
	 *     unrecognized: array<int, string>,
	 *     invalid: array<int, array{
	 *         variation: string,
	 *         spec: Shurloc_Mesh_Specification
	 *     }>
	 * }
	 */
	public function analyze(
		array $variations
	): array {

		$report = array(
			'recognized'   => array(),
			'unrecognized' => array(),
			'invalid'      => array(),
		);

		foreach ( $variations as $variation ) {

			$spec = $this->parser->parse( $variation );

			if ( ! $spec->recognized ) {
				$report['unrecognized'][] = $variation;
				continue;
			}

			$entry = array(
				'variation' => $variation,
				'spec'      => $spec,
			);

			$report['recognized'][] = $entry;

			if ( ! $spec->is_valid() ) {
				$report['invalid'][] = $entry;
			}
		}

		return $report;
	}
}
