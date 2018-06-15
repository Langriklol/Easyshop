<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 5/7/18
 * Time: 1:45 PM
 */

namespace App\CoreModule\Model\Shop;
use Nette;
use Nette\Utils\ArrayHash;

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
        $this->products[] = $product;
        return $this;
    }

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
        $productCount = [];
        $productIndexer = [];
        if($this->products) {
            foreach ($this->products as $product) {
                if(isset($productCount[$product->getId()]))
                    $productCount[$product->getId()]++;
                else
                    $productCount[$product->getId()] = 1;
            }
            $productFrontend = [];
            foreach ($this->products as $product) {
                if(!isset($productIndexer[$product->getId()])) {
                    $productFrontend[] = [
                        'id' => $product->getId(),
                        'name' => $product->getName(),
                        'description' => $product->getDescription(),
                        'category' => $product->getCategory(),
                        'manufacturer' => $product->getManufacturer(),
                        'price' => $product->getPrice(),
                        'availability' => $product->getAvailability(),
                        'image' => $product->getImage(),
                        'count' => $productCount[$product->getId()]
                    ];
                    $productIndexer[$product->getId()] = 1;
                }
            }
            return ArrayHash::from($productFrontend);
        }
        return ArrayHash::from([]);
    }
}