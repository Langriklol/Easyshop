<?php

namespace App\CoreModule\Model\Shop;

use Nette\Utils\ArrayHash;

class Product
{
    const AVAILABLE = 'Available',
        WAITING = 'Waiting',
        UNAVAILABLE = 'Unavailable';

    /**
     * @var int $id product id
     */
    private $id;

    /**
     * @var string $name product name
     */
    private $name;

    /**
     * @var string $manufacturer
     */
    private $manufacturer;

    /**
     * @var string $category
     */
    private $category;

    /**
     * @var int $price product price
     */
    private $price;
    
    /**
     * @var string $description product description
     */
    private $description;

    /**
     * @var string $image product image url
     */
    private $image;

    /**
     * @var int $availability Availability of product
     */
    private $availability;

    public function __construct()
    {
    }
    
    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int? $id
     * @return Product
     */
    public function setId(int $id = null): Product
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return Product
     */
    public function setPrice(int $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Product
     */
    public function setDescription(string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \Nette\Utils\ArrayHash $arrayHash
     */
    public function toArrayHash():ArrayHash
    {
        return ArrayHash::from([
            'product_id' => $this->getId(),
            'name' => $this->getName(),
            'manufacturer' => $this->getManufacturer(),
            'category' => $this->getCategory(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
            'image' => $this->getImage()
        ]);
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image product image url
     * @return Product
     */
    public function setImage(string $image): Product
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvailability(): string
    {
        return $this->availability;
    }

    /**
     * @param string $availability
     * @return Product
     */
    public function setAvailability(string $availability): Product
    {
        $this->availability = $availability;
        return $this;
    }

    /**
     * @return string
     */
    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    /**
     * @param string $manufacturer
     * @return Product
     */
    public function setManufacturer(string $manufacturer): Product
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    /**
     * @param string $category
     * @return Product
     */
    public function setCategory(string $category): Product
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }
}