<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 5/7/18
 * Time: 1:45 PM
 */

namespace App\CoreModule\Model\Shop;


class Basket
{
    /**
     * @var array|Product[] $products product array
     */
    protected $products;

    public function __construct()
    {
    }

    /**
     * @return Product[] products in basket
     */
    public function getProducts(): array
    {
        return $this->products;
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
        $this->products[$product->getId()][] = $product;
        return $this;
    }

    public function removeProduct(Product $product)
    {
        $count = count($this->products[$product->getId()]);
        unset($this->products[$product->getId()][$count]);
    }
}