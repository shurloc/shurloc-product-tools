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

		$remaining = $this->normalize( $text );

		$this->extract_price( $remaining, $spec );
		$this->extract_pack_size( $remaining, $spec );

		// Tokenize the rest of the string.
		$tokens = preg_split( '/\s+/', $remaining );

		if ( false === $tokens ) {
			return $spec;
		}

		// Process tokens.
		foreach ( $tokens as $token ) {
			$this->classify_token( $token, $spec );
		}

		return $spec;
	}

	/**
	 * Normalize a mesh specification string.
	 *
	 * @param string $text Raw variation text.
	 * @return string Normalized text.
	 */
	private function normalize( string $text ): string {

		// Trim text.
		$text = trim( $text );

		// Normalize whitespace.
		$text = preg_replace(
			'/\s+/',
			' ',
			$text
		);

		// Normalize "Thin Thread".
		$text = preg_replace(
			'/Thin\s+Thread/i',
			'(S)',
			$text
		);

		return $text;
	}
	/**
	 * Extract price from specification string.
	 *
	 * @param string                     &$remaining The spec string from which to extract the price.
	 * @param Shurloc_Mesh_Specification $spec The spec to update.
	 */
	private function extract_price(
		string &$remaining,
		Shurloc_Mesh_Specification $spec
	): void {
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
	}

	/**
	 * Extract pack size from specification string.
	 *
	 * @param string                     &$remaining The spec string from which to extract the pack size.
	 * @param Shurloc_Mesh_Specification $spec The spec to update.
	 */
	private function extract_pack_size(
		string &$remaining,
		Shurloc_Mesh_Specification $spec
	): void {
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
	}

	/**
	 * Classify a token from the specification string.
	 *
	 * @param string                     $token The spec string from which to extract the pack size.
	 * @param Shurloc_Mesh_Specification $spec The spec to update.
	 */
	private function classify_token(
		string $token,
		Shurloc_Mesh_Specification $spec
	): void {

		// Mesh/thread token.
		if ( preg_match( '/^(\d+)\/(\d+)$/', $token, $matches ) ) {
			$spec->mesh_count      = (int) $matches[1];
			$spec->thread_diameter = (int) $matches[2];
			return;
		}

		// Color.
		if ( 'white' === strtolower( $token ) || 'yellow' === strtolower( $token ) ) {
			$spec->color = ucfirst( $token );
			return;
		}

		// Modifier.
		if ( preg_match( '/^\s*\(?(S|M|HD)\)?\s*$/i', $token, $matches ) ) {
			$spec->modifier = strtoupper( $matches[1] );
			return;
		}

		// Unknown tokens.
		$spec->unknown_tokens[] = $token;
	}
}
