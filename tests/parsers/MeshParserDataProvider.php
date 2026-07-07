<?php
/**
 * Test data for the mesh parser.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh parser test cases.
 */
final class MeshParserDataProvider {

	/**
	 * Standard mesh specifications.
	 *
	 * @return array<string, array{0:string,1:Shurloc_Mesh_Specification}>
	 */
	public static function standard_mesh(): array {

		return array(
			'110/80 Yellow' => array(
				'110/80 Yellow $23.75',
				self::spec(
					mesh_count: 110,
					thread_diameter: 80,
					color: 'Yellow',
					price_text: '$23.75',
				),
			),

			'60/120 White'  => array(
				'60/120 White $22.36',
				self::spec(
					mesh_count: 60,
					thread_diameter: 120,
					color: 'White',
					price_text: '$22.36',
				),
			),
		);
	}

	/**
	 * Create a specification.
	 *
	 * @param int|null    $mesh_count      Mesh count.
	 * @param int|null    $thread_diameter Thread diameter.
	 * @param string|null $modifier        Modifier.
	 * @param string|null $color           Mesh color.
	 * @param string|null $pack_size       Pack size.
	 * @param string|null $price_text      Price.
	 * @return Shurloc_Mesh_Specification
	 */
	private static function spec(
		?int $mesh_count = null,
		?int $thread_diameter = null,
		?string $modifier = null,
		?string $color = null,
		?string $pack_size = null,
		?string $price_text = null
	): Shurloc_Mesh_Specification {

		$spec = new Shurloc_Mesh_Specification();

		$spec->mesh_count      = $mesh_count;
		$spec->thread_diameter = $thread_diameter;
		$spec->modifier        = $modifier;
		$spec->color           = $color;
		$spec->pack_size       = $pack_size;
		$spec->price_text      = $price_text;

		return $spec;
	}
}
