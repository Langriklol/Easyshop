<?php

namespace App\CoreModule\Model\Shop;

use Nette\Utils\ArrayHash;

class Product
{
    /**
     * @var int $id product id
     */
    private $id;

    /**
     * @var string $name product name
     */
    private $name;

    /**
     * @var int $price product price
     */
    private $price;
    
    /**
     * @var string $description product description
     */
    private $description;

    public function __construct()
    {

    }
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function setId(int $id): Product
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
}