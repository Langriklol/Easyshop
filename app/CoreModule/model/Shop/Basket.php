<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 5/7/18
 * Time: 1:45 PM
 */

namespace App\CoreModule\Model\Shop;

use Nette\Utils\ArrayHash;
use Langriklol\Utils\ProductSortHelper;

class Basket
{
    /**
     * @var array|Product[] $products product array
     */
    protected $products;

    /**
     * @var ProductSortHelper
     */
    private $sortHelper;

    public function __construct()
    {
        $this->products = [];
        $this->sortHelper = new ProductSortHelper();
    }

    /**
     * Simple product getter
     * @return Product[] products in basket
     */
    public function getProducts(): array
    {
        return $this->products ?: [];
    }

    /**
     * Fluent setter
     * @param Product[] $products
     * @return Basket
     */
    public function setProducts(array $products)
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @param Product $product product to add into basket
     * @return Basket $this fluent setter
     */
    public function addProduct(Product $product): Basket
    {
        if(empty($this->products)){
            $this->products[0] = $product;
        }else{
            $this->products[] = $product;
        }
        return $this;
    }

    /**
     * Removes product from basket
     * @param Product $product
     */
    public function removeProduct(Product $product)
    {
        foreach ($this->products as $key => $item)
        {
            if($item->getId() === $product->getId())
            {
                unset($this->products[$key]);
                return;
            }
        }
    }

    /**
     * @return ArrayHash $products Make array for frontend
     */
    public function renderProductFrontend(): ArrayHash
    {
        return $this->sortHelper->sortProductFrontEnd($this->products);
    }
}