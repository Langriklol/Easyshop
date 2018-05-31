<?php

namespace App\CoreModule\Presenters;

use App\Presenters\BasePresenter;
use App\CoreModule\Model\ProductManager;
use Nette\Utils\ArrayHash;

class ProductPresenter extends BasePresenter
{
    /**
     * @var ProductManager @inject
     */
    private $productManager;

    public function renderDefault(/*int $id*/)
    {
        //$this->template->product = $this->productManager->getProduct($id);
        $this->template->product = ArrayHash::from([
            'name' => 'product',
            'description' => 'product description',
            'price' => 'moc',
            'image' => 'https://5.imimg.com/data5/AW/QD/MY-23353183/flower-pot-500x500.jpg'
        ]);
    }

    public function createComponentProductEditor()
    {

    }
}