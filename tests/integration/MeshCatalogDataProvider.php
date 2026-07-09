<?php
/**
 * Catalog fixture data provider.
 *
 * Loads variation names exported from WooCommerce.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Catalog data provider.
 */
final class MeshCatalogDataProvider {

	/**
	 * Load every variation from the catalog fixture.
	 *
	 * @return string[]
	 * @throws JsonException    If the JSON fixture is invalid.
	 * @throws RuntimeException If the fixture cannot be read.
	 */
	public static function load_catalog(): array {

		$filename = dirname( __DIR__ ) . '/data/catalog-variations.json';

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Reading a local test fixture.
		$json = file_get_contents( $filename );

		if ( false === $json ) {
			throw new RuntimeException(
				'Unable to read catalog fixture.'
			);
		}

		$variations = json_decode(
			$json,
			true,
			512,
			JSON_THROW_ON_ERROR
		);

		if ( ! is_array( $variations ) ) {
			throw new RuntimeException(
				'Catalog fixture does not contain an array.'
			);
		}

		$data = array();

		foreach ( $variations as $variation ) {
			if ( is_string( $variation ) ) {
				$data[] = $variation;
			}
		}

		return $data;
	}

	/**
	 * Return catalog variations as PHPUnit datasets.
	 *
	 * @return array<string, array{0:string}>
	 * @throws JsonException    If the JSON fixture is invalid.
	 * @throws RuntimeException If the fixture cannot be read.
	 */
	public static function catalog_variations(): array {

		$data = array();

		foreach ( self::load_catalog() as $variation ) {
			$data[ $variation ] = array( $variation );
		}

		return $data;
	}
}
