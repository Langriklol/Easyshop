<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 6/12/18
 * Time: 11:26 PM
 */

namespace App\CoreModule\Presenters;

use App\CoreModule\Model\Shop\ProductManager;
use App\Presenters\BasePresenter;
use Nette;

class BasketPresenter extends BasePresenter
{
    /** @var ProductManager  */
    private $productManager;

    /**
     * BasketPresenter constructor.
     * @param ProductManager $productManager
     */
    public function __construct(ProductManager $productManager)
    {
        parent::__construct();
        $this->productManager = $productManager;
    }

    /**
     * @param int $id Adds product of quantity one to basket
     */
    public function handleAdd(int $id)
    {
        $product = $this->productManager->getProduct($id);
        $this->basket->addProduct($product);
        $this->flashMessage('You added one item to your basket.');
    }

    /**
     * @param int $id Removes product of quantity one from basket
     */
    public function handleRemove(int $id)
    {
        $product = $this->productManager->getProduct($id);
        $this->basket->removeProduct($product);
        $this->flashMessage('Product was removed.');
    }

    /**
     * @throws Nette\Application\AbortException
     */
    public function actionOrder()
    {
        $this->redirect('Order:default');
    }
    
    /**
     *  Render basket front end
     */
    public function renderDefault()
    {
        $product = $this->productManager->getProduct(6);
        //$this->basket->addProduct($product);
        bdump($this->basket->renderProductFrontend());
        $this->template->products = $this->basket->renderProductFrontend();
        $request = $this->getHttpRequest();
        bdump($request->getRemoteHost());
    }
}