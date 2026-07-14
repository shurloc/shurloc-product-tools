<?php
/**
 * Product schema renderer.
 *
 * Converts generated product schema arrays into JSON-LD script output
 * suitable for embedding in a webpage head section.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Product schema renderer.
 */
final class Shurloc_Product_Schema_Renderer {

	/**
	 * Render product schema as JSON-LD.
	 *
	 * Outputs a Schema.org JSON-LD script tag.
	 *
	 * @param array<string,mixed> $schema Product schema data.
	 * @return void
	 */
	public function render(
		array $schema
	): void {

		echo '<script type="application/ld+json">';
		echo wp_json_encode(
			$schema,
			JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
		);
		echo '</script>';
		echo "\n";
	}
}
