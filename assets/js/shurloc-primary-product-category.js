/**
 * Primary product category admin behavior.
 *
 * Initializes the primary-category SelectWoo field and highlights the
 * corresponding category in the standard product category checklist.
 *
 * @package ShurlocProductTools
 */

( function ( $ ) {
	'use strict';

	const SELECTOR = '.shurloc-primary-product-category';
	const HIGHLIGHT_CLASS = 'shurloc-primary-product-category-highlight';

	/**
	 * Initialize SelectWoo for the primary-category selector.
	 *
	 * @return {void}
	 */
	function initializeSelectWoo() {
		const $select = $( SELECTOR );

		if ( ! $select.length || typeof $.fn.selectWoo !== 'function' ) {
			return;
		}

		if ( $select.hasClass( 'select2-hidden-accessible' ) ) {
			return;
		}

		$select.selectWoo( {
			width: '100%',
			allowClear: true,
			placeholder: 'Select a primary category',
		} );
	}

	/**
	 * Remove the primary-category highlight from the category checklist.
	 *
	 * @return {void}
	 */
	function clearCategoryHighlight() {
		$( '#product_catchecklist li' )
			.removeClass( HIGHLIGHT_CLASS );
	}

	/**
	 * Highlight the selected primary category in the product category
	 * checklist.
	 *
	 * @return {void}
	 */
	function updateCategoryHighlight() {
		const $select = $( SELECTOR );

		clearCategoryHighlight();

		if ( ! $select.length ) {
			return;
		}

		const termId = parseInt(
			$select.val(),
			10
		);

		if ( ! termId ) {
			return;
		}

		$( '#product_cat-' + termId )
			.addClass( HIGHLIGHT_CLASS );
	}

	/**
	 * Register primary-category field behavior.
	 *
	 * @return {void}
	 */
	function registerEvents() {
		$( document ).on(
			'change',
			SELECTOR,
			updateCategoryHighlight
		);
	}

	/**
	 * Initialize primary-product-category admin behavior.
	 *
	 * @return {void}
	 */
	function initialize() {
		initializeSelectWoo();
		registerEvents();
		updateCategoryHighlight();
	}

	$( initialize );

} )( jQuery );
