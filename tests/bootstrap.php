<?php
/**
 * PHPUnit bootstrap.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __DIR__ ) . DIRECTORY_SEPARATOR );
}

// Load Composer's autoloader.
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

// Load service interfaces.
require_once dirname( __DIR__ ) . '/includes/services/interface-shurloc-product-schema-service.php';
require_once dirname( __DIR__ ) . '/includes/services/interface-shurloc-product-catalog-service.php';
require_once dirname( __DIR__ ) . '/includes/services/interface-shurloc-mesh-product-schema-service.php';

// Load renderer interfaces.
require_once dirname( __DIR__ ) . '/includes/renderers/interface-shurloc-product-schema-renderer.php';

// Load models.
require_once dirname( __DIR__ ) . '/includes/models/class-shurloc-mesh-specification.php';
require_once dirname( __DIR__ ) . '/includes/models/class-shurloc-catalog-variation-entry.php';
require_once dirname( __DIR__ ) . '/includes/models/class-shurloc-catalog-product-entry.php';
require_once dirname( __DIR__ ) . '/includes/models/class-shurloc-mesh-product-result.php';

// Load parsers.
require_once dirname( __DIR__ ) . '/includes/parsers/class-shurloc-mesh-parser.php';

// Load analyzers.
require_once dirname( __DIR__ ) . '/includes/analyzers/class-shurloc-catalog-analyzer.php';
require_once dirname( __DIR__ ) . '/includes/analyzers/class-shurloc-mesh-product-analyzer.php';

// Load services.
require_once dirname( __DIR__ ) . '/includes/services/class-shurloc-product-catalog-service.php';
require_once dirname( __DIR__ ) . '/includes/services/class-shurloc-mesh-product-schema-service.php';
require_once dirname( __DIR__ ) . '/includes/services/class-shurloc-product-schema-service.php';

// Load generators.
require_once dirname( __DIR__ ) . '/includes/generators/class-shurloc-product-schema-generator.php';

// Load reports.
require_once dirname( __DIR__ ) . '/includes/reports/class-shurloc-catalog-report.php';

// Load integrations.
require_once dirname( __DIR__ ) . '/includes/integrations/class-shurloc-product-schema-integration.php';
require_once dirname( __DIR__ ) . '/includes/integrations/class-shurloc-woocommerce-schema-integration.php';

// Load renderers.
require_once dirname( __DIR__ ) . '/includes/renderers/class-shurloc-product-schema-renderer.php';

// Load test utilities.
require_once dirname( __DIR__ ) . '/tests/parsers/MeshParserDataProvider.php';
require_once dirname( __DIR__ ) . '/tests/integration/MeshCatalogDataProvider.php';

// Load WordPress test doubles.
require_once dirname( __DIR__ ) . '/tests/doubles/class-wc-product.php';

// WordPress function stubs.

if ( ! function_exists( 'wp_json_encode' ) ) {

	/**
	 * WordPress JSON encode test stub.
	 *
	 * @param mixed $value Value to encode.
	 * @param int   $flags JSON encode flags.
	 * @param int   $depth Maximum depth.
	 * @return string|false
	 */
	function wp_json_encode(
		$value,
		int $flags = 0,
		int $depth = 512
	) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.json_encode_json_encode
		return json_encode(
			$value,
			$flags,
			$depth
		);
	}
}

$GLOBALS['shurloc_test_is_product'] = true;
$GLOBALS['shurloc_test_filters']    = array();
$GLOBALS['shurloc_test_actions']    = array();

if ( ! function_exists( 'is_product' ) ) {

	/**
	 * Determine whether current page is a product page.
	 *
	 * @return bool
	 */
	function is_product(): bool {

		return $GLOBALS['shurloc_test_is_product'];
	}
}

if ( ! function_exists( 'get_the_ID' ) ) {

	/**
	 * Get current post ID.
	 *
	 * @return int
	 */
	// phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid, Squiz.Commenting.FunctionComment.Missing
	function get_the_ID(): int {

		return 123;
	}
}

if ( ! function_exists( 'wc_get_product' ) ) {

	/**
	 * Get test WooCommerce product.
	 *
	 * @param int $id Product ID.
	 * @return WC_Product Test product.
	 */
	function wc_get_product(
		int $id
	): WC_Product {

		return new WC_Product( $id );
	}
}

if ( ! function_exists( 'add_filter' ) ) {

	/**
	 * Register test filter.
	 *
	 * @param string   $hook Hook name.
	 * @param callable $callback Callback.
	 * @param int      $priority Priority.
	 * @param int      $accepted_args Accepted arguments.
	 * @return true
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed, Squiz.Commenting.FunctionComment.Missing
	function add_filter(
		string $hook,
		$callback,
		int $priority = 10,
		int $accepted_args = 1
	): bool {

		$GLOBALS['shurloc_test_filters'][ $hook ][] = $callback;

		return true;
	}
}

if ( ! function_exists( 'apply_filters' ) ) {

	/**
	 * Apply test filters.
	 *
	 * @param string $hook Hook name.
	 * @param mixed  $value Value to filter.
	 * @return mixed
	 */
	function apply_filters(
		string $hook,
		$value
	) {

		if ( empty( $GLOBALS['shurloc_test_filters'][ $hook ] ) ) {
			return $value;
		}

		foreach ( $GLOBALS['shurloc_test_filters'][ $hook ] as $callback ) {
			$value = $callback( $value );
		}

		return $value;
	}
}

if ( ! function_exists( 'add_action' ) ) {

	/**
	 * Register test action.
	 *
	 * @param string   $hook Hook name.
	 * @param callable $callback Callback.
	 * @param int      $priority Priority.
	 * @param int      $accepted_args Accepted arguments.
	 * @return true
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed, Squiz.Commenting.FunctionComment.Missing
	function add_action(
		string $hook,
		$callback,
		int $priority = 10,
		int $accepted_args = 1
	): bool {

		$GLOBALS['shurloc_test_actions'][ $hook ][] = $callback;

		return true;
	}
}

if ( ! function_exists( 'do_action' ) ) {

	/**
	 * Execute test actions.
	 *
	 * @param string $hook Hook name.
	 * @param mixed  ...$args Action arguments.
	 * @return void
	 */
	function do_action(
		string $hook,
		...$args
	): void {

		if ( empty( $GLOBALS['shurloc_test_actions'][ $hook ] ) ) {
			return;
		}

		foreach ( $GLOBALS['shurloc_test_actions'][ $hook ] as $callback ) {
			$callback( ...$args );
		}
	}
}
