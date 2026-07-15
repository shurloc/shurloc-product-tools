<?php
/**
 * Removes Yoast Product schema.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Yoast schema integration.
 */
final class Shurloc_Yoast_Schema_Integration {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public function register(): void {

		add_filter(
			'wpseo_json_ld_output',
			array( $this, 'remove_product_schema' )
		);
	}

	/**
	 * Remove Yoast Product schema nodes.
	 *
	 * @param array<int,array<string,mixed>> $data Schema graph.
	 * @return array<int,array<string,mixed>>
	 */
	public function remove_product_schema(
		array $data
	): array {

		foreach ( $data as $key => $node ) {

			if (
				isset( $node['@type'] )
				&& 'Product' === $node['@type']
			) {
				unset( $data[ $key ] );
			}
		}

		return array_values( $data );
	}
}
