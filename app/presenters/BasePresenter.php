<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;
use App\CoreModule\Model\Shop\Basket;
use Nette;

/**
 * Base presenter
 * @package App\Presenters
 */
abstract class BasePresenter extends Presenter
{
   /**
    * @var Nette\Http\Session
   */
   protected $session;

    /**
   * @var Basket
   */
   protected $basket;

   protected $loginPresenter = ':Core:Auth:login';

    /**
     * @throws Nette\Application\AbortException
     */
    public function startup()
   {
       parent::startup();
       $this->session = $this->getSession('basket');
       $this->session->basket = ($this->session->basket instanceof Basket) ? $this->session->basket : new Basket();
       $this->basket = &$this->session->basket;
       $this->template->basketItemCount = count($this->basket->getProducts());

       bdump($this->basket, 'Basket');

       if (!$this->getUser()->isAllowed($this->getName(), $this->getAction()) && !$this->getUser()->getIdentity()) {
           $this->flashMessage('You are not logged in or have not permission to do this.');
           if ($this->loginPresenter)
               $this->redirect($this->loginPresenter);
       }
   }

}