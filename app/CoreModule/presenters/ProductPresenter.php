<?php

use App\Presenters\BasePresenter;
use App\CoreModule\Model\ProductManager;

class ProductPresenter extends BasePresenter
{
    /**
     * @var ProductManager @inject
     */
    private $productManager;

    public function renderDefault(int $id)
    {
        $this->template->product = $this->productManager->getProduct($id);
    }

    public function createComponentProductEditor()
    {

    }
}