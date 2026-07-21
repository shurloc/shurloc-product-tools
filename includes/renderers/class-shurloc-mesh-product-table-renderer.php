<?php
/**
 * Mesh product table renderer.
 *
 * Renders a customer-facing HTML table from normalized mesh table data.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product table renderer.
 */
final class Shurloc_Mesh_Product_Table_Renderer implements Shurloc_Mesh_Product_Table_Renderer_Interface {

	/**
	 * Render a mesh specification table.
	 *
	 * @param Shurloc_Mesh_Table_Data $data Mesh table data.
	 * @return string HTML table.
	 */
	public function render(
		Shurloc_Mesh_Table_Data $data
	): string {

		$rows = $data->get_rows();

		if ( empty( $rows ) ) {
			return '';
		}

		$html  = '<table class="shurloc-mesh-specification-table">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th>Mesh</th>';
		$html .= '<th>Thread</th>';
		$html .= '<th>Modifier</th>';
		$html .= '<th>Color</th>';
		$html .= '<th>Pack Size</th>';
		$html .= '<th>Price</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';

		foreach ( $rows as $row ) {

			$html .= '<tr>';

			$html .= '<td>' .
				esc_html(
					(string) $row->get_mesh_count()
				) .
				'</td>';

			$html .= '<td>' .
				esc_html(
					(string) $row->get_thread_diameter()
				) .
				'</td>';

			$html .= '<td>';

			if ( null !== $row->get_modifier() ) {

				$html .= esc_html(
					$row->get_modifier()
				);
			}

			$html .= '</td>';

			$html .= '<td>' .
				esc_html(
					$row->get_color()
				) .
				'</td>';

			$html .= '<td>';

			if ( null !== $row->get_pack_size() ) {

				$html .= esc_html(
					$row->get_pack_size()
				);
			}

			$html .= '</td>';

			$html .= '<td>';

			if ( null !== $row->get_price() ) {

				$html .= esc_html(
					sprintf(
						'$%.2f',
						$row->get_price()
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
