<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 6/23/18
 * Time: 10:20 PM
 */

namespace App\CoreModule\Model\Shop\Order;

use App\CoreModule\Model\Shop\Product;
use App\CoreModule\Model\Shop\ProductManager;
use Nette;


class Order
{
    use Nette\SmartObject;

    const PENDING = 'pending',
        CANCELED = 'canceled',
        DONE = 'done';
    const TABLE = 'order',
        ID = 'id';

    /** @var int */
    private $id;
    /** @var int */
    private $user;
    /** @var string */
    private $name;
    /** @var Product[] */
    private $products;
    /** @var string */
    private $status;
    /** @var string */
    private $description;
    /** @var string */
    private $orderType;
    /** @var string */
    private $createdAt;

    public function __construct()
    {
    }

    /**
     * @param int $id
     * @return Order
     */
    public function setId($id): Order
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $user
     * @return Order
     */
    public function setUser($user): Order
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }

    /**
     * @param string $name
     * @return Order
     */
    public function setName($name): Order
    {
        $this->name = $name;
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
     * @param Product[] $products
     * @return Order
     */
    public function setProducts(array $products): Order
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return Order
     */
    public function setStatus($status): Order
    {
        $this->status = $status;
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
     * @return Order
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderType(): string
    {
        return $this->orderType;
    }

    /**
     * @param string $orderType
     * @return Order
     */
    public function setOrderType(string $orderType)
    {
        $this->orderType = $orderType;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return Order
     */
    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}