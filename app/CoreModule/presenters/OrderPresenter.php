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
use App\Forms\AdministrationFormFactory;
use App\Presenters\BasePresenter;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class OrderPresenter extends BasePresenter
{
    /**
     * @var OrderManager
     */
    private $orderManager;
    /** @var AdministrationFormFactory */
    private $formFactory;

    public function __construct(OrderManager $orderManager, AdministrationFormFactory $formFactory)
    {
        parent::__construct();
        $this->orderManager =  $orderManager;
        $this->formFactory = $formFactory;
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
            //$this->redirect('Product:list');
        }
    }

    public function actionNewOrder()
    {
        $this->flashMessage('New order!');
    }
    
    public function createComponentNewOrderForm(): Form
    {
        $form = $this->formFactory->createNewOrderForm();
        $form->onSuccess[] = [$this, 'makeOrder'];
        return $form;
    }
    
    public function renderList()
    {
        $this->template->orders = $this->orderManager->getOrders();
    }

    public function makeOrder(Form $form, $values)
    {
        $description = $values->description;
        $name = $values->name;
        $this->orderManager->makeOrder($this->user->getId(), $this->basket->getProducts(), Order::PENDING_STATUS, Order::TYPE_CASH_ON_DELIVERY, $description, $name);
    }
}