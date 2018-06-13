<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 6/12/18
 * Time: 11:26 PM
 */

namespace App\CoreModule\Presenters;

use App\CoreModule\Model\ProductManager;
use App\Presenters\BasePresenter;
use Nette;

class BasketPresenter extends BasePresenter
{
    /** @var ProductManager  */
    private $productManager;

    public function __construct(ProductManager $productManager)
    {
        parent::__construct();
        $this->productManager = $productManager;
    }

    public function actionAdd(int $productId)
    {
        $product = $this->productManager->getProduct($productId);
        $this->basket->addProduct($product);
        $this->flashMessage('You added one item to your basket.');
    }

    public function renderDefault()
    {
        $this->template->products = $this->basket->getProducts();
    }
}