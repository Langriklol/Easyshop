<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 6/24/18
 * Time: 12:25 AM
 */

namespace App\CoreModule\Presenters;

use App\CoreModule\Model\Shop\Order\OrderManager;
use App\Presenters\BasePresenter;

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

    public function renderDefault(int $id)
    {
        $order = $this->orderManager->getOrder($id);
        bdump($order, 'Order');
        $this->template->order = $order;
    }

    public function renderList()
    {
        $this->template->orders = $this->orderManager->getOrders();
    }



}