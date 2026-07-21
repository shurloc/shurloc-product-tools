<?php
/**
 * WordPress function test doubles.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Test product state.
 *
 * @var bool
 */
$GLOBALS['shurloc_test_is_product'] = true;

/**
 * Registered test filters.
 *
 * @var array<string,array<int,callable>>
 */
$GLOBALS['shurloc_test_filters'] = array();

/**
 * Registered test actions.
 *
 * @var array<string,array<int,callable>>
 */
$GLOBALS['shurloc_test_actions'] = array();

/**
 * Registered test action metadata.
 *
 * @var array<string,array<int,array<string,int>>>
 */
$GLOBALS['shurloc_test_action_metadata'] = array();

/**
 * Stored taxonomy terms.
 *
 * @var array<int,array<string,array<int,string>>>
 */
$GLOBALS['shurloc_test_terms'] = array();

/**
 * Stored product comments.
 *
 * @var array<int,array<int,object>>
 */
$GLOBALS['shurloc_test_comments'] = array();

/**
 * Registered WooCommerce test products.
 *
 * @var array<int,WC_Product>
 */
$GLOBALS['shurloc_test_products'] = array();

/**
 * Stored shortcode registrations.
 *
 * @var array<string,array<string,callable>>
 */
$GLOBALS['wp_shortcodes'] = array();

/**
 * Stored product.
 *
 * @var string|null
 */
$GLOBALS['product'] = null;

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
	 * @return WC_Product|null Test product.
	 */
	function wc_get_product(
		int $id
	): ?WC_Product {

		if ( isset( $GLOBALS['shurloc_test_products'][ $id ] ) ) {
			return $GLOBALS['shurloc_test_products'][ $id ];
		}

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

		if ( ! isset( $GLOBALS['shurloc_test_actions'] ) ) {

			$GLOBALS['shurloc_test_actions'] = array();
		}

		$GLOBALS['shurloc_test_actions'][ $hook ][] = $callback;

		$GLOBALS['shurloc_test_action_metadata'][ $hook ][] = array(
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		);

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


if ( ! function_exists( 'get_edit_post_link' ) ) {

	/**
	 * Get edit post link.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $context Context.
	 * @return string
	 */
    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed, Squiz.Commenting.FunctionComment.Missing
	function get_edit_post_link(
		int $post_id,
		string $context = ''
	): string {

		return 'https://example.com/wp-admin/post.php?post=' . $post_id;
	}
}


if ( ! function_exists( 'get_permalink' ) ) {

	/**
	 * Get permalink.
	 *
	 * @param int $post_id Post ID.
	 * @return string
	 */
	function get_permalink(
		int $post_id
	): string {

		return 'https://example.com/product/' . $post_id . '/';
	}
}


if ( ! function_exists( 'wp_set_object_terms' ) ) {

	/**
	 * Set object terms.
	 *
	 * @param int          $object_id Object ID.
	 * @param string|array $terms Terms.
	 * @param string       $taxonomy Taxonomy.
	 * @return bool
	 */
	function wp_set_object_terms(
		int $object_id,
		$terms,
		string $taxonomy
	): bool {

		if ( ! isset( $GLOBALS['shurloc_test_terms'][ $object_id ] ) ) {
			$GLOBALS['shurloc_test_terms'][ $object_id ] = array();
		}

		$GLOBALS['shurloc_test_terms'][ $object_id ][ $taxonomy ] = (array) $terms;

		return true;
	}
}


if ( ! function_exists( 'get_the_terms' ) ) {

	/**
	 * Get object terms.
	 *
	 * @param int    $object_id Object ID.
	 * @param string $taxonomy Taxonomy.
	 * @return array<int,string>
	 */
	function get_the_terms(
		int $object_id,
		string $taxonomy
	): array {

		return $GLOBALS['shurloc_test_terms'][ $object_id ][ $taxonomy ] ?? array();
	}
}

if ( ! function_exists( 'wp_get_post_terms' ) ) {

	/**
	 * Get post terms.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $taxonomy Taxonomy.
	 * @param array  $args Arguments.
	 * @return array<int,string>
	 */
    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed, Squiz.Commenting.FunctionComment.Missing
	function wp_get_post_terms(
		int $post_id,
		string $taxonomy,
		array $args = array()
	): array {

		return $GLOBALS['shurloc_test_terms'][ $post_id ][ $taxonomy ] ?? array();
	}
}

if ( ! function_exists( 'wp_get_attachment_image_url' ) ) {

	/**
	 * Get attachment image URL.
	 *
	 * @param int    $attachment_id Attachment ID.
	 * @param string $size Image size.
	 * @return string|false
	 */
    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed, Squiz.Commenting.FunctionComment.Missing
	function wp_get_attachment_image_url(
		int $attachment_id,
		string $size = 'full'
	) {

		return false;
	}
}

if ( ! function_exists( 'is_wp_error' ) ) {

	/**
	 * Determine whether a value is a WP_Error object.
	 *
	 * @param mixed $thing Value to check.
	 * @return bool
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found, Squiz.Commenting.FunctionComment.Missing
	function is_wp_error(
		$thing
	): bool {

		return false;
	}
}

if ( ! function_exists( 'get_comments' ) ) {

	/**
	 * Get test comments.
	 *
	 * @param array<string,mixed> $args Comment query arguments.
	 * @return array<int,object>
	 */
	function get_comments(
		array $args = array()
	): array {

		$post_id = $args['post_id'] ?? 0;

		return $GLOBALS['shurloc_test_comments'][ $post_id ] ?? array();
	}
}

if ( ! function_exists( 'shurloc_register_test_product' ) ) {

	/**
	 * Register WooCommerce test product.
	 *
	 * @param WC_Product $product Product object.
	 * @return void
	 */
	function shurloc_register_test_product(
		WC_Product $product
	): void {

		$GLOBALS['shurloc_test_products'][ $product->get_id() ] = $product;
	}
}

if ( ! function_exists( 'plugin_dir_path' ) ) {

	/**
	 * Return plugin directory path stub.
	 *
	 * @param string $file Plugin file.
	 * @return string
	 */
	function plugin_dir_path(
		string $file
	): string {

		return defined( 'SHURLOC_PRODUCT_TOOLS_PATH' )
			? SHURLOC_PRODUCT_TOOLS_PATH
			: dirname( $file ) . DIRECTORY_SEPARATOR;
	}
}

if ( ! function_exists( 'plugin_dir_url' ) ) {

	/**
	 * Return plugin URL stub.
	 *
	 * @param string $file Plugin file.
	 * @return string
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found, Squiz.Commenting.FunctionComment.Missing
	function plugin_dir_url(
		string $file
	): string {

		return 'https://example.com/wp-content/plugins/shurloc-product-tools/';
	}
}

if ( ! function_exists( 'plugin_dir_path' ) ) {

	/**
	 * Return plugin path stub.
	 *
	 * @param string $file Plugin file.
	 * @return string
	 */
	function plugin_dir_path(
		string $file
	): string {

		return dirname( $file ) . DIRECTORY_SEPARATOR;
	}
}

if ( ! function_exists( 'check_admin_referer' ) ) {

	/**
	 * Test nonce verification.
	 *
	 * @param string $action Nonce action.
	 * @return true
	 */
	function check_admin_referer( string $action ): bool {

		$GLOBALS['shurloc_test_nonce_checks'][] = $action;

		return true;
	}
}

if ( ! function_exists( 'sanitize_key' ) ) {

	/**
	 * Sanitize a key.
	 *
	 * @param string $key Key.
	 * @return string
	 */
	function sanitize_key(
		string $key
	): string {

		return strtolower(
			preg_replace(
				'/[^a-z0-9_\-]/',
				'',
				$key
			)
		);
	}
}

if ( ! function_exists( 'wp_unslash' ) ) {

	/**
	 * Remove slashes.
	 *
	 * @param mixed $value Value.
	 * @return mixed
	 */
	function wp_unslash( $value ) {

		return stripslashes_deep( $value );
	}
}

if ( ! function_exists( 'stripslashes_deep' ) ) {

	/**
	 * Remove slashes recursively.
	 *
	 * @param mixed $value Value.
	 * @return mixed
	 */
	function stripslashes_deep( $value ) {

		if ( is_array( $value ) ) {

			return array_map(
				'stripslashes_deep',
				$value
			);
		}

		return stripslashes( $value );
	}
}

if ( ! function_exists( 'current_user_can' ) ) {

	/**
	 * Capability check stub.
	 *
	 * @param string $capability Capability name.
	 * @return bool
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found, Squiz.Commenting.FunctionComment.Missing
	function current_user_can( string $capability ): bool {

		return true;
	}
}

if ( ! function_exists( 'esc_html' ) ) {
	/**
	 * Escape HTML output.
	 *
	 * @param string $text Text to escape.
	 * @return string Escaped text.
	 */
	function esc_html(
		string $text
	): string {

		return htmlspecialchars(
			$text,
			ENT_QUOTES | ENT_SUBSTITUTE,
			'UTF-8'
		);
	}
}

if ( ! function_exists( 'add_shortcode' ) ) {
	/**
	 * Register a shortcode callback.
	 *
	 * @param string   $tag      Shortcode tag.
	 * @param callable $callback Shortcode callback.
	 * @return bool True when the shortcode is registered.
	 */
	function add_shortcode(
		string $tag,
		callable $callback
	): bool {

		if ( ! isset( $GLOBALS['wp_shortcodes'] ) ) {
			$GLOBALS['wp_shortcodes'] = array();
		}

		$GLOBALS['wp_shortcodes'][ $tag ] = $callback;

		return true;
	}
}

if ( ! function_exists( 'wc_get_product' ) ) {
	/**
	 * Retrieve a WooCommerce product test double.
	 *
	 * @param int $product_id Product ID.
	 * @return WC_Product|null Product double or null.
	 */
	function wc_get_product(
		int $product_id
	): ?WC_Product {

		return $GLOBALS['shurloc_test_products'][ $product_id ] ?? null;
	}
}
