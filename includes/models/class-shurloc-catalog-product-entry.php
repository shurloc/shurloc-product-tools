<?php
/**
 * Catalog product entry model.
 *
 * Represents a WooCommerce product and its catalog variations.
 * Contains the product-level information required for catalog analysis
 * and structured data generation.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Catalog product entry.
 */
final class Shurloc_Catalog_Product_Entry {

	/**
	 * Product ID.
	 *
	 * @var int
	 */
	public int $product_id;

	/**
	 * Product name.
	 *
	 * @var string
	 */
	public string $product_name;

	/**
	 * Product edit URL.
	 *
	 * @var string
	 */
	public string $edit_url;

	/**
	 * Public product URL.
	 *
	 * @var string
	 */
	public string $product_url;

	/**
	 * Product SKU.
	 *
	 * @var string
	 */
	public string $sku;

	/**
	 * Product image URL.
	 *
	 * @var string|null
	 */
	public ?string $image_url;

	/**
	 * Product current price.
	 *
	 * @var float|null
	 */
	public ?float $price;

	/**
	 * Product regular price.
	 *
	 * @var float|null
	 */
	public ?float $regular_price;

	/**
	 * Product sale price.
	 *
	 * @var float|null
	 */
	public ?float $sale_price;

	/**
	 * Product availability.
	 *
	 * @var string
	 */
	public string $availability;

	/**
	 * Product variations.
	 *
	 * @var Shurloc_Catalog_Variation_Entry[]
	 */
	public array $variations;

	/**
	 * Constructor.
	 *
	 * @param int                               $product_id Product ID.
	 * @param string                            $product_name Product name.
	 * @param string                            $edit_url Product edit URL.
	 * @param string                            $product_url Public product URL.
	 * @param string                            $sku Product SKU.
	 * @param string|null                       $image_url Product image URL.
	 * @param float|null                        $price Product current price.
	 * @param float|null                        $regular_price Product regular price.
	 * @param float|null                        $sale_price Product sale price.
	 * @param string                            $availability Product availability.
	 * @param Shurloc_Catalog_Variation_Entry[] $variations Product variations.
	 */
	public function __construct(
		int $product_id,
		string $product_name,
		string $edit_url,
		string $product_url,
		string $sku,
		?string $image_url,
		?float $price,
		?float $regular_price,
		?float $sale_price,
		string $availability,
		array $variations
	) {

		$this->product_id    = $product_id;
		$this->product_name  = $product_name;
		$this->edit_url      = $edit_url;
		$this->product_url   = $product_url;
		$this->sku           = $sku;
		$this->image_url     = $image_url;
		$this->price         = $price;
		$this->regular_price = $regular_price;
		$this->sale_price    = $sale_price;
		$this->availability  = $availability;
		$this->variations    = $variations;
	}
}
