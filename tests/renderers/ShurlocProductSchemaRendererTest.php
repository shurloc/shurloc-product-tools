<?php
/**
 * Tests for Shurloc_Product_Schema_Renderer.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests product schema rendering.
 */
final class ShurlocProductSchemaRendererTest extends TestCase {

	/**
	 * Renderer should output JSON-LD script markup.
	 */
	public function test_renders_schema_as_json_ld_script(): void {

		$renderer = new Shurloc_Product_Schema_Renderer();

		$schema = array(
			'@context' => 'https://schema.org',
			'@type'    => 'Product',
			'name'     => 'Test Product',
		);

		ob_start();

		$renderer->render(
			$schema
		);

		$output = ob_get_clean();

		$this->assertStringContainsString(
			'<script type="application/ld+json">',
			$output
		);

		$this->assertStringContainsString(
			'</script>',
			$output
		);

		$this->assertStringContainsString(
			'"@context":"https://schema.org"',
			$output
		);

		$this->assertStringContainsString(
			'"@type":"Product"',
			$output
		);

		$this->assertStringContainsString(
			'"name":"Test Product"',
			$output
		);
	}

	/**
	 * Renderer should preserve escaped JSON characters.
	 */
	public function test_renders_special_characters_safely(): void {

		$renderer = new Shurloc_Product_Schema_Renderer();

		$schema = array(
			'@context' => 'https://schema.org',
			'@type'    => 'Product',
			'name'     => 'Test "Special" Product',
		);

		ob_start();

		$renderer->render(
			$schema
		);

		$output = ob_get_clean();

		$this->assertStringContainsString(
			'Test \\"Special\\" Product',
			$output
		);
	}

	/**
	 * Renderer should not escape slashes in URLs.
	 */
	public function test_renders_urls_without_escaping_slashes(): void {

		$renderer = new Shurloc_Product_Schema_Renderer();

		$schema = array(
			'@context' => 'https://schema.org',
			'@type'    => 'Product',
			'url'      => 'https://example.com/product/test/',
		);

		ob_start();

		$renderer->render(
			$schema
		);

		$output = ob_get_clean();

		$this->assertStringContainsString(
			'https://example.com/product/test/',
			$output
		);

		$this->assertStringNotContainsString(
			'https:\/\/example.com',
			$output
		);
	}
}
