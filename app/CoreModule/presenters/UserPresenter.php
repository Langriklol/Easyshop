<?php
/**
 * Created by PhpStorm.
 * User: olangr
 * Date: 7/11/18
 * Time: 3:26 PM
 */

namespace App\CoreModule\Presenters;


use App\Presenters\BasePresenter;
use Nette\Database\Context;
use Nette\Security\User;

class UserPresenter extends BasePresenter
{
    /** @var Context */
    private $context;

    /**
     * UserPresenter constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct();
        $this->context = $context;
    }

    /**
     * @throws \Nette\Application\AbortException
     */
    public function startup()
    {
        parent::startup();
        $id = (int) $this->presenter->getParameter('id');
        if($id && (int) $this->user->getId() !== $id)
        {
            $this->flashMessage('You are not allowed to do this');
            $this->redirect('Product:list');
        }elseif (!$id) {
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
            $user = $this->context->table('user')->select('email, name, picture, residence, phone, ico')->get($id);
            $orders = $user->related('order.user');
            bdump($orders);
            $this->template->user = $user;
            $this->template->orders = $orders;
        }else{
            $this->redirect('User:list');
        }
    }

    /**
     * Displays all users
     */
    public function actionList()
    {
        $this->template->users = $this->context->table('user')->select('email, name, picture, residence, phone, ico')->fetchAll();
    }
}