<?php
/**
 * Created by PhpStorm.
 * User: olangr
 * Date: 7/11/18
 * Time: 3:26 PM
 */

namespace App\CoreModule\Presenters;

use App\CoreModule\Model\Shop\Order\OrderManager;
use App\Presenters\BasePresenter;
use Nette\Database\Context;
use Nette\Database\Table\ActiveRow;
use Nette\Security\User;

class UserPresenter extends BasePresenter
{
    /** @var Context */
    private $context;
    /** @var OrderManager  */
    private $orderManager;

    /**
     * UserPresenter constructor.
     * @param Context $context
     * @param OrderManager $orderManager
     */
    public function __construct(Context $context, OrderManager $orderManager)
    {
        parent::__construct();
        $this->context = $context;
        $this->orderManager = $orderManager;
    }

    /**
     * @throws \Nette\Application\AbortException
     * @throws \Nette\Application\BadRequestException
     */
    public function startup()
    {
        parent::startup();
        $id = (int) $this->presenter->getParameter('id');
        bdump($id, 'id');
        if(($id && (int) $this->user->getId() !== $id) && $this->getUser()->isInRole('admin') == false)
        {
            bdump($id && (int) $this->user->getId() !== $id, 'firstCond');
            $this->error('You are not allowed to do this');
            $this->redirect('Product:list');

        }elseif (!$id && $this->getUser()->isInRole('admin') == false) {
            $this->redirect('Auth:login');
        }
    }

    /**
     * @param int|null $id
     * @throws \Nette\Application\AbortException
     */
    public function renderDefault(int $id = null)
    {
        if($id){

            $user = $this->context->table('user')->select('user_id, email, name, picture, residence, phone, ico')->where('user_id', $id)->get($id);
            bdump($user, 'User db');
            $orders = $user->related('order.user');

            $orderArray = [];

            foreach ($orders as $order) {
                $orderArray[] = $this->orderManager->getOrder($order->id);
                unset($order);
            }
            unset($orders);

            foreach ($orderArray as $order){
                $order->setProducts($this->orderManager->renderOrderProductFrontEnd($order));
            }

            bdump($orderArray, 'Orders');

            $this->template->user = $user;
            $this->template->orders = $orderArray;
            $this->template->identityId = $this->getUser()->getId();
        }else{
            $this->redirect('User:list');
        }
    }

    /**
     * @param string $key
     * @param $value
     * @throws \Nette\Application\BadRequestException
     */
    public function handleUpdate(string $key, $value)
    {
        try{
            $this->context->table('user')->where('user_id')->update([$key => $value]);
        }catch (\PDOException $e){
            $this->error($e->getMessage());
        }
    }

    /**
     * Displays all users
     */
    public function actionList()
    {
        $this->template->users = $this->context->table('user')->select('user_id, email, name, picture, residence, phone, ico, role')->fetchAll();
    }
}