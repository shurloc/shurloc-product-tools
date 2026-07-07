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
			'110/80 Yellow'          => array(
				'110/80 Yellow $23.75',
				self::spec(
					raw: '110/80 Yellow $23.75',
					mesh_count: 110,
					thread_diameter: 80,
					color: 'Yellow',
					price_text: '$23.75',
				),
			),

			'60/120 White'           => array(
				'60/120 White $22.36',
				self::spec(
					raw: '60/120 White $22.36',
					mesh_count: 60,
					thread_diameter: 120,
					color: 'White',
					price_text: '$22.36',
				),
			),

			'110/80 Orange'          => array(
				'110/180 Orange $23.75',
				self::spec(
					raw: '110/180 Orange $23.75',
					mesh_count: 110,
					thread_diameter: 180,
					color: null,
					price_text: '$23.75',
					unknown_tokens: array( 'Orange' ),
				),
			),

			'110/71 (S) White'       => array(
				'110/71 (S) White $23.75',
				self::spec(
					raw: '110/71 (S) White $23.75',
					mesh_count: 110,
					thread_diameter: 71,
					modifier: 'S',
					color: 'White',
					price_text: '$23.75',
					unknown_tokens: array(),
				),
			),

			'5 Pack - 110/80 Yellow' => array(
				'5 Pack - 110/80 Yellow ($98.55)',
				self::spec(
					raw: '5 Pack - 110/80 Yellow ($98.55)',
					mesh_count: 110,
					thread_diameter: 80,
					modifier: null,
					color: 'Yellow',
					pack_size: '5 Pack',
					price_text: '($98.55)',
					unknown_tokens: array(),
				),
			),
		);
	}

	/**
	 * Create a specification.
	 *
	 * @param string      $raw             Raw variation string.
	 * @param int|null    $mesh_count      Mesh count.
	 * @param int|null    $thread_diameter Thread diameter.
	 * @param string|null $modifier        Modifier.
	 * @param string|null $color           Mesh color.
	 * @param string|null $pack_size       Pack size.
	 * @param string|null $price_text      Price.
	 * @param string[]    $unknown_tokens Unknown tokens.
	 * @return Shurloc_Mesh_Specification
	 */
	private static function spec(
		string $raw,
		?int $mesh_count = null,
		?int $thread_diameter = null,
		?string $modifier = null,
		?string $color = null,
		?string $pack_size = null,
		?string $price_text = null,
		?array $unknown_tokens = array()
	): Shurloc_Mesh_Specification {

		$spec = new Shurloc_Mesh_Specification();

		$spec->raw             = $raw;
		$spec->mesh_count      = $mesh_count;
		$spec->thread_diameter = $thread_diameter;
		$spec->modifier        = $modifier;
		$spec->color           = $color;
		$spec->pack_size       = $pack_size;
		$spec->price_text      = $price_text;
		$spec->unknown_tokens  = $unknown_tokens;

		return $spec;
	}
}
