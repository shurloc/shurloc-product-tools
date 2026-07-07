<?php
/**
 * Mesh specification parser.
 *
 * @package ShurLocProductTools
 */

/**
 * Parses mesh specification strings.
 */
class Shurloc_Mesh_Parser {

	/**
	 * Parse a mesh specification.
	 *
	 * @param string $text Raw variation text.
	 * @return Shurloc_Mesh_Specification Parsed mesh specification.
	 */
	public function parse( string $text ): Shurloc_Mesh_Specification {

		$spec      = new Shurloc_Mesh_Specification();
		$spec->raw = $text;

		return $spec;
	}
}
