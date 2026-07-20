<?php
/**
 * Mesh product table renderer.
 *
 * Renders a customer-facing HTML table of recognized mesh variations.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product table renderer.
 */
final class Shurloc_Mesh_Product_Table_Renderer {

	/**
	 * Render a mesh specification table.
	 *
	 * @param Shurloc_Mesh_Product_Result $result Mesh product analysis result.
	 * @return string HTML table.
	 */
	public function render(
		Shurloc_Mesh_Product_Result $result
	): string {

		$rows = $result->get_mesh_variations();

		if ( empty( $rows ) ) {
			return '';
		}

		$html  = '<table class="shurloc-mesh-specification-table">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th>Mesh</th>';
		$html .= '<th>Thread</th>';
		$html .= '<th>Color</th>';
		$html .= '<th>Price</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';

		foreach ( $rows as $row ) {

			$entry = $row['entry'];
			$spec  = $row['spec'];

			$html .= '<tr>';

			$html .= '<td>' .
				esc_html(
					(string) $spec->mesh_count
				) .
				'</td>';

			$html .= '<td>' .
				esc_html(
					(string) $spec->thread_diameter
				) .
				'</td>';

			$html .= '<td>' .
				esc_html(
					$spec->color
				) .
				'</td>';

			$html .= '<td>';

			if ( null !== $entry->price ) {

				$html .= esc_html(
					sprintf(
						'$%.2f',
						$entry->price
					)
				);
			}

			$html .= '</td>';

			$html .= '</tr>';
		}

		$html .= '</tbody>';
		$html .= '</table>';

		return $html;
	}
}
