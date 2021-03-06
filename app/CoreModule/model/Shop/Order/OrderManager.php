<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 6/23/18
 * Time: 11:06 PM
 */

namespace App\CoreModule\Model\Shop\Order;

use App\CoreModule\Model\Shop\ProductManager;
use App\Model\BaseManager;
use Nette\Database\Context;
use Nette\Utils\ArrayHash;
use Langriklol\Utils\ProductSortHelper;

class OrderManager extends BaseManager
{
    private $productManager;
    private $sortHelper;

    /**
     * OrderManager constructor.
     * @param Context $context
     * @param ProductManager $productManager
     * @param ProductSortHelper $sortHelper
     */
    public function __construct(Context $context, ProductManager $productManager, ProductSortHelper $sortHelper)
    {
        parent::__construct($context);
        $this->productManager = $productManager;
        $this->sortHelper = $sortHelper;
    }

    /**
     * @param int $id
     * @return Order
     */
    public function getOrder(int $id)
    {
        $orderDb = $this->db->table(Order::TABLE)->get($id);
        $products = $this->makeProducts($orderDb->products);
        $order = new Order();
        $order->setId($orderDb->id)
            ->setUser($orderDb->user)
            ->setName($orderDb->name)
            ->setProducts($products)
            ->setStatus($orderDb->status)
            ->setDescription($orderDb->description)
            ->setOrderType($orderDb->order_type)
            ->setCreatedAt($orderDb->created_at);
        return $order;
    }

    public function getOrders()
    {
        $orders = $this->db->table(Order::TABLE)->fetchAll();
        $orders = ArrayHash::from($orders);
        foreach ($orders as $order) {
            $orders = $this->makeProducts($order->products);
        }
        return $orders;
    }

    public function makeOrder(int $user, array $products, string $status, string $orderType, string $description, string $name = null)
    {
        $productArray = $this->storeProducts($products);

        $order = [
            'name' => $name,
            'user' => $user,
            'products' => $productArray,
            'description' => $description,
            'status' => $status,
            'order_type' => $orderType
        ];

        return $this->db->table(Order::TABLE)->insert($order);
    }

    public function cancelOrder(int $orderId)
    {
        $order = $this->db->table(Order::TABLE)->get($orderId);
        $order = $order->toArray();
        $order['status'] = Order::CANCELED_STATUS;
        return $this->db->table(Order::TABLE)->where(Order::ID, $orderId)->update($order);
    }

    private function makeProducts(string $productsId)
    {
        $products = explode(',', $productsId);
        $productArray = [];
        foreach ($products as $product) {
            $productArray[] = $this->productManager->getProduct($product);
        }
        return $productArray;
    }

    public function renderOrderProductFrontEnd(Order $order): ArrayHash
    {
        return $this->sortHelper->sortProductFrontEnd($order->products);
    }

    public function storeProducts(array $products): string
    {
        $productArray = '';

        foreach ($products as $product)
        {
            if($productArray == '')
                $productArray = (string) $product->id;
            else
                $productArray .= ',' . $product->id;
        }
        return $productArray;
    }
}