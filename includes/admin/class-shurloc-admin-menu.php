<?php
/**
 * Product Tools admin menu.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Registers Product Tools admin UI.
 */
final class Shurloc_Admin_Menu {

	/**
	 * Parent ShurLoc Tools menu slug.
	 */
	private const PARENT_MENU_SLUG = 'shurloc-tools';

	/**
	 * Product Tools menu slug.
	 */
	private const PRODUCT_MENU_SLUG = 'shurloc-product-tools';

	/**
	 * Required capability.
	 */
	private const CAPABILITY = 'manage_options';

	/**
	 * Product menu position.
	 */
	private const PRODUCT_MENU_POSITION = 10;

	/**
	 * Product page.
	 *
	 * @var Shurloc_Catalog_Report_Controller
	 */
	private Shurloc_Catalog_Report_Controller $product_page;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Catalog_Report_Controller $product_page Product page.
	 */
	public function __construct(
		Shurloc_Catalog_Report_Controller $product_page
	) {
		$this->product_page = $product_page;
	}

	/**
	 * Register WordPress hooks.
	 *
	 * @return void
	 */
	public function register(): void {

		add_action(
			'admin_menu',
			array( $this, 'register_menu' ),
			20
		);

		add_action(
			'shurloc_tools_overview',
			array( $this, 'render_overview_section' ),
			self::PRODUCT_MENU_POSITION
		);
	}

	/**
	 * Register the Product Tools submenu.
	 *
	 * @return void
	 */
	public function register_menu(): void {

		add_submenu_page(
			self::PARENT_MENU_SLUG,
			'ShurLoc Product Tools',
			'Products',
			self::CAPABILITY,
			self::PRODUCT_MENU_SLUG,
			array( $this->product_page, 'render_page' ),
			self::PRODUCT_MENU_POSITION
		);
	}

	/**
	 * Render the Product Tools overview section.
	 *
	 * @return void
	 */
	public function render_overview_section(): void {
		?>
		<h2>Products</h2>

		<p>
			Product catalog analysis, mesh specification tools,
			structured data, breadcrumbs, and product recommendations.
		</p>

		<p>
			<a
				href="<?php echo esc_url( $this->get_product_tools_url() ); ?>"
				class="button button-primary"
			>
				Open Product Tools
			</a>
		</p>
		<?php
	}

	/**
	 * Get the Product Tools admin URL.
	 *
	 * @return string
	 */
	private function get_product_tools_url(): string {

		return add_query_arg(
			array(
				'page' => self::PRODUCT_MENU_SLUG,
			),
			admin_url( 'admin.php' )
		);
	}
}