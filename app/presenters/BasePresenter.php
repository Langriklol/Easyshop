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

   public function startup()
   {
       parent::startup();
       $this->session = $this->getSession('basket');
       $this->basket = $this->session->basket ?: new Basket();
       $this->template->basket = count($this->basket->getProducts());
       bdump($this->basket);
   }

}