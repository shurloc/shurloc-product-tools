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

		// Don't mutate $test.
		$remaining = trim( $text );

		// Normalize spaces.
		$remaining = preg_replace(
			'/\s+/',
			' ',
			$remaining
		);

		// Normalize "Thin Thread".
		$remaining = preg_replace(
			'/Thin\s+Thread/i',
			'(S)',
			$remaining
		);

		// Extract the trailing price.
		if ( preg_match( '/(\(?\$\d+\.\d{2}\)?)$/', $remaining, $matches ) ) {
			$spec->price_text = $matches[1];
			$remaining        = trim(
				substr(
					$remaining,
					0,
					-strlen( $matches[1] )
				)
			);
		}

		// Extract the pack size.
		if ( preg_match( '/^(\d+\s+Pack)(\s*\-\s*)/i', $remaining, $matches ) ) {
			$spec->pack_size = $matches[1];
			$remaining       = trim(
				substr(
					$remaining,
					strlen( $matches[1] ) + strlen( $matches[2] ),
					strlen( $remaining )
				)
			);
		}

		// Tokenize the rest of the string.
		$tokens = preg_split( '/\s+/', $remaining );

		if ( false === $tokens ) {
			return $spec;
		}

		// Process tokens.
		foreach ( $tokens as $token ) {

			// Mesh/thread token.
			if ( preg_match( '/^(\d+)\/(\d+)$/', $token, $matches ) ) {
				$spec->mesh_count      = (int) $matches[1];
				$spec->thread_diameter = (int) $matches[2];
				continue;
			}

			// Color.
			if ( 'white' === strtolower( $token ) || 'yellow' === strtolower( $token ) ) {
				$spec->color = ucfirst( $token );
				continue;
			}

			// Modifier.
			if ( preg_match( '/^\s*\(?(S|M|HD)\)?\s*$/i', $token, $matches ) ) {
				$spec->modifier = strtoupper( $matches[1] );
				continue;
			}

			// Unknown tokens.
			$spec->unknown_tokens[] = $token;
		}

		return $spec;
	}
}
