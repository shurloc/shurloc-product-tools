<?php
/**
 * ShurLoc admin menu.
 *
 * Registers the shared ShurLoc Tools admin menu and the Product Tools
 * submenu page.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * Registers ShurLoc admin menu pages.
 */
final class Shurloc_Admin_Menu {

	/**
	 * Parent menu slug.
	 *
	 * @var string
	 */
	private const PARENT_MENU_SLUG = 'shurloc-tools';

	/**
	 * Product Tools page slug.
	 *
	 * @var string
	 */
	private const PRODUCT_MENU_SLUG = 'shurloc-product-tools';

	/**
	 * Product Tools submenu position.
	 *
	 * ShurLoc Tools submenu positions:
	 *
	 * 10 - Products
	 * 20 - Customers
	 * 30 - Checkout
	 *
	 * @var int
	 */
	private const PRODUCT_MENU_POSITION = 10;

	/**
	 * Required capability.
	 *
	 * @var string
	 */
	private const CAPABILITY = 'manage_options';

	/**
	 * Product Tools admin page.
	 *
	 * @var Shurloc_Admin_Page_Interface
	 */
	private Shurloc_Admin_Page_Interface $product_page;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Admin_Page_Interface $product_page Product Tools admin page.
	 */
	public function __construct(
		Shurloc_Admin_Page_Interface $product_page
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
			array(
				$this,
				'register_menu',
			),
			20
		);
	}

	/**
	 * Register the ShurLoc Tools admin menu.
	 *
	 * @return void
	 */
	public function register_menu(): void {

		if ( ! $this->parent_menu_exists() ) {
			$this->register_parent_menu();
		}

		$this->register_product_menu();
		$this->rename_parent_submenu();
	}

	/**
	 * Register the shared ShurLoc Tools parent menu.
	 *
	 * @return void
	 */
	private function register_parent_menu(): void {

		add_menu_page(
			'ShurLoc Tools',
			'ShurLoc Tools',
			self::CAPABILITY,
			self::PARENT_MENU_SLUG,
			array(
				$this,
				'render_overview_page',
			),
			'dashicons-admin-tools',
			56
		);
	}

	/**
	 * Register the Product Tools submenu.
	 *
	 * @return void
	 */
	private function register_product_menu(): void {

		add_submenu_page(
			self::PARENT_MENU_SLUG,
			'ShurLoc Product Tools',
			'Products',
			self::CAPABILITY,
			self::PRODUCT_MENU_SLUG,
			array(
				$this->product_page,
				'render_page',
			),
			self::PRODUCT_MENU_POSITION
		);
	}

	/**
	 * Determine whether the shared parent menu is already registered.
	 *
	 * This allows multiple ShurLoc plugins to share the same parent menu
	 * without depending on a specific plugin load order.
	 *
	 * @return bool
	 */
	private function parent_menu_exists(): bool {

		global $menu;

		if ( ! is_array( $menu ) ) {
			return false;
		}

		foreach ( $menu as $menu_item ) {

			if (
				isset( $menu_item[2] ) &&
				self::PARENT_MENU_SLUG === $menu_item[2]
			) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Rename WordPress's automatically generated parent submenu.
	 *
	 * WordPress automatically inserts the top-level parent page as the first
	 * submenu item when child pages are registered. Keep that submenu so the
	 * top-level ShurLoc Tools menu continues to open the overview page, but
	 * rename it to "Overview" for clarity.
	 *
	 * @return void
	 */
	private function rename_parent_submenu(): void {

		global $submenu;

		if (
			! isset( $submenu[ self::PARENT_MENU_SLUG ] ) ||
			! is_array( $submenu[ self::PARENT_MENU_SLUG ] )
		) {
			return;
		}

		foreach ( $submenu[ self::PARENT_MENU_SLUG ] as &$submenu_item ) {

			if (
				isset( $submenu_item[2] ) &&
				self::PARENT_MENU_SLUG === $submenu_item[2]
			) {
				$submenu_item[0] = 'Overview';
				break;
			}
		}

		unset( $submenu_item );
	}

	/**
	 * Render the ShurLoc Tools overview page.
	 *
	 * @return void
	 */
	public function render_overview_page(): void {
		?>

		<div class="wrap">

			<h1>ShurLoc Tools</h1>

			<p>
				Administrative tools for ShurLoc WooCommerce operations.
			</p>

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

		</div>

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
