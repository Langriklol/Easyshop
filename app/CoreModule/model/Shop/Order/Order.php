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
use Nette\Utils\ArrayHash;
use Nette;

/**
 * Class Order
 * @package App\CoreModule\Model\Shop\Order
 * @property int $id
 * @property int $user
 * @property string $name
 * @property Product[]|ArrayHash $products
 * @property string $status
 * @property string $description
 * @property string $orderType
 * @property string $createdAt
 */
class Order
{
    use Nette\SmartObject;

    const PENDING_STATUS = 'pending',
        CANCELED_STATUS = 'canceled',
        DONE_STATUS = 'done';

    const TYPE_PAID = 'paid',
        TYPE_CASH_ON_DELIVERY = 'cash on delivery';

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
     * @param Product[]|ArrayHash $products
     * @return Order
     */
    public function setProducts($products): Order
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @return Product[]|ArrayHash
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return string
     */
    public function getStatus(): string
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