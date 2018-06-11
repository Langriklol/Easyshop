<?php

namespace App\CoreModule\Model\Shop;

class ProductFactory
{
    public function __construct()
    {
    }


    /**
     * @param int $id product id
     * @param string $name product name
     * @param string $manufacturer
     * @param string $category
     * @param float $price product price
     * @param string $description product description
     * @param string $image product image
     * @param string $availability
     * @return Product $product
     */
    public function createProduct(?int $id, string $name, string $manufacturer, string $category, float $price, string $description, string $image, string $availability): Product
    {
        $product = new Product();
        $product->setId($id)
            ->setName($name)
            ->setManufacturer($manufacturer)
            ->setCategory($category)
            ->setPrice($price)
            ->setDescription($description)
            ->setImage($image)
            ->setAvailability($availability);
        return $product;
    }
}