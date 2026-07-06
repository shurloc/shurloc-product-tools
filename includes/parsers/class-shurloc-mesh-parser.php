<?php
/**
 * Mesh specification parser.
 *
 * @package ShurLocProductTools
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Parses mesh specification strings.
 */
class Shurloc_Mesh_Parser {

	/**
	 * Parse a mesh specification.
	 *
	 * @param string $text Raw variation text.
	 * @return Shurloc_Mesh_Specification|WP_Error
	 */
	public function parse( string $text ) {

		$spec      = new Shurloc_Mesh_Specification();
		$spec->raw = $text;

		return $spec;
	}
}
