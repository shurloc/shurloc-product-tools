<?php
/**
 * Divi WooCommerce breadcrumb separator.
 *
 * Replaces Divi Woo Breadcrumb separator text nodes with a solid SVG arrow.
 *
 * The Divi Woo Breadcrumb module must use "/" as its separator.
 *
 * @package ShurLoc_Product_Tools
 */

declare(strict_types=1);

defined( 'ABSPATH' ) || exit;

/**
 * Replaces Divi breadcrumb separators with SVG arrows.
 */
final class Shurloc_Breadcrumb_Separator {

	/**
	 * Inline asset handle.
	 *
	 * @var string
	 */
	private const ASSET_HANDLE = 'shurloc-breadcrumb-separator';

	/**
	 * Register WordPress hooks.
	 *
	 * @return void
	 */
	public function register(): void {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ), 20 );
	}

	/**
	 * Enqueue the separator CSS and JavaScript.
	 *
	 * @return void
	 */
	public function enqueue_assets(): void {

		if ( ! function_exists( 'is_product' ) || ! is_product() ) {
			return;
		}

		wp_register_style(
			self::ASSET_HANDLE,
			false,
			array(),
			SHURLOC_PRODUCT_TOOLS_VERSION
		);

		wp_enqueue_style( self::ASSET_HANDLE );

		wp_add_inline_style(
			self::ASSET_HANDLE,
			$this->get_css()
		);

		wp_register_script(
			self::ASSET_HANDLE,
			false,
			array(),
			SHURLOC_PRODUCT_TOOLS_VERSION,
			true
		);

		wp_enqueue_script( self::ASSET_HANDLE );

		wp_add_inline_script(
			self::ASSET_HANDLE,
			$this->get_javascript()
		);
	}

	/**
	 * Get the breadcrumb separator CSS.
	 *
	 * @return string
	 */
	private function get_css(): string {
		return '
			.et_pb_wc_breadcrumb .shurloc-breadcrumb-separator {
				display: inline-flex;
				flex: 0 0 auto;
				align-items: center;
				justify-content: center;
				width: 0.45em;
				height: 0.7em;
				margin: 0 1.25em;
				color: inherit;
				vertical-align: middle;
			}

			.et_pb_wc_breadcrumb .shurloc-breadcrumb-separator svg {
				display: block;
				width: 100%;
				height: 100%;
				overflow: visible;
			}
		';
	}

	/**
	 * Get the breadcrumb separator JavaScript.
	 *
	 * @return string
	 */
	private function get_javascript(): string {
		return <<<'JS'
(function () {
	'use strict';

	const breadcrumbSelector = '.et_pb_wc_breadcrumb .woocommerce-breadcrumb';
	const svgNamespace = 'http://www.w3.org/2000/svg';

	/**
	 * Create a solid SVG breadcrumb separator.
	 *
	 * @returns {HTMLSpanElement}
	 */
	function createSeparator() {
		const span = document.createElement('span');
		const svg = document.createElementNS(svgNamespace, 'svg');
		const polygon = document.createElementNS(svgNamespace, 'polygon');

		span.className = 'shurloc-breadcrumb-separator';
		span.setAttribute('aria-hidden', 'true');

		svg.setAttribute('viewBox', '0 0 8 12');
		svg.setAttribute('focusable', 'false');
		svg.setAttribute('aria-hidden', 'true');

		polygon.setAttribute('points', '1,0 7,6 1,12');
		polygon.setAttribute('fill', 'currentColor');

		svg.appendChild(polygon);
		span.appendChild(svg);

		return span;
	}

	/**
	 * Replace separator text nodes in a breadcrumb.
	 *
	 * Handles both standalone separator nodes and the final text node
	 * containing the separator followed by the current product name.
	 *
	 * @param {Element} breadcrumb Breadcrumb container.
	 *
	 * @returns {void}
	 */
	function replaceSeparators(breadcrumb) {
		const childNodes = Array.from(breadcrumb.childNodes);

		childNodes.forEach(function (node) {
			let match;
			let remainder;
			let separator;

			if (node.nodeType !== Node.TEXT_NODE) {
				return;
			}

			if (!node.textContent) {
				return;
			}

			match = node.textContent.match(/^\s*\/\s*(.*)$/s);

			if (!match) {
				return;
			}

			remainder = match[1];
			separator = createSeparator();

			if (remainder === '') {
				node.replaceWith(separator);
				return;
			}

			node.replaceWith(
				separator,
				document.createTextNode(remainder)
			);
		});
	}

	/**
	 * Replace separators in all Divi Woo Breadcrumb modules.
	 *
	 * @returns {void}
	 */
	function initializeBreadcrumbSeparators() {
		document
			.querySelectorAll(breadcrumbSelector)
			.forEach(replaceSeparators);
	}

	if (document.readyState === 'loading') {
		document.addEventListener(
			'DOMContentLoaded',
			initializeBreadcrumbSeparators
		);
	} else {
		initializeBreadcrumbSeparators();
	}
}());
JS;
	}
}
