<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 6/24/18
 * Time: 12:25 AM
 */

namespace App\CoreModule\Presenters;

use App\CoreModule\Model\Shop\Order\Order;
use App\CoreModule\Model\Shop\Order\OrderManager;
use App\Presenters\BasePresenter;
use Nette\Utils\ArrayHash;

class OrderPresenter extends BasePresenter
{
    /**
     * @var OrderManager
     */
    private $orderManager;

    public function __construct(OrderManager $orderManager)
    {
        parent::__construct();
        $this->orderManager =  $orderManager;
    }

    /**
     * @param int $id
     * @throws \Nette\Application\AbortException
     */
    public function renderDefault(int $id = null)
    {
        if($id) {
            $order = $this->orderManager->getOrder($id);
            $order->setProducts($this->orderManager->renderOrderProductFrontEnd($order));
            bdump($order, 'Frontended order');
            $this->template->order = $order;
        }else{
            $this->flashMessage('Missing order id');
            $this->redirect('Product:list');
        }
    }

    public function renderList()
    {
        $this->template->orders = $this->orderManager->getOrders();
    }

    public function actionMake()
    {
        $products = '';
        foreach ($this->basket->getProducts() as $product)
        {
            $products = $product ? ',' . $product->id : $product->id;
        }

        $order = [
            'id' => null,
            'name' => '',
            'products' => $products,
            'status' => Order::PENDING_STATUS,
            'orderType' => Order::TYPE_CASH_ON_DELIVERY
        ];

        $this->orderManager->makeOrder(ArrayHash::from($order));
    }
}