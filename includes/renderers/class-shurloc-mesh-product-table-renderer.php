<?php
/**
 * Mesh product table renderer.
 *
 * Renders a customer-facing HTML table of mesh specifications.
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
	 * @param Shurloc_Mesh_Table_Data $data Presentation-ready table data.
	 * @return string HTML table.
	 */
	public function render(
		Shurloc_Mesh_Table_Data $data
	): string {

		if ( ! $data->has_rows() ) {
			return '';
		}

		$rows = $data->get_rows();

		$html  = '<table class="shurloc-mesh-specification-table">';
		$html .= '<thead>';
		$html .= '<tr>';

		$html .= '<th>Mesh</th>';
		$html .= '<th>Thread</th>';

		if ( $data->show_modifier_column() ) {

			$html .= '<th>Modifier</th>';
		}

		$html .= '<th>Color</th>';

		if ( $data->show_pack_size_column() ) {

			$html .= '<th>Pack Size</th>';
		}

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

			if ( $data->show_modifier_column() ) {

				$html .= '<td>';

				if ( null !== $row->get_modifier() ) {

					$html .= esc_html(
						$row->get_modifier()
					);
				}

				$html .= '</td>';
			}

			$html .= '<td>' .
				esc_html(
					$row->get_color()
				) .
				'</td>';

			if ( $data->show_pack_size_column() ) {

				$html .= '<td>';

				if ( null !== $row->get_pack_size() ) {

					$html .= esc_html(
						$row->get_pack_size()
					);
				}

				$html .= '</td>';
			}

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
