<?php

namespace App\CoreModule\Presenters;

use App\CoreModule\Model\Shop\Product;
use App\Forms\AdministrationFormFactory;
use App\Presenters\BasePresenter;
use App\CoreModule\Model\ProductManager;
use http\Exception\BadUrlException;
use Nette\Application\BadRequestException;
use Nette\Utils\ArrayHash;

class ProductPresenter extends BasePresenter
{
    /**
     * @var ProductManager $productManager
     */
    private $productManager;

    /**
     * @var AdministrationFormFactory $formFactory
     */
    private $formFactory;

    public function __construct(ProductManager $productManager, AdministrationFormFactory $formFactory)
    {
        parent::__construct();
        $this->productManager = $productManager;
        $this->formFactory = $formFactory;
    }

    public function actionAdd()
    {
        
    }

    /**
     * @param int $id
     * @throws BadRequestException
     */
    public function actionEdit(int $id)
    {
        if($id){
            $product = $this->productManager->getProduct($id);
            $product ?
                $this['productEditorForm']->setDefaults($product->toArrayHash()):
                $this->flashMessage('Product not found.');
        }else{
            throw new BadRequestException();
        }
    }

    /**
     * @param int $id
     * @throws \Nette\Application\AbortException
     * @throws \http\Exception\BadUrlException
     */
    public function actionDelete(int $id)
    {
        if($id)
        {
            try{
                $product = $this->productManager->getProduct($id);
                $this->productManager->deleteProduct($product);
                $this->redirect('Product:list');
            }catch (BadUrlException $e) {
                throw $e;
            }

        }
    }

    /**
     * @param int|null $id
     */
    public function renderDefault(int $id = null)
    {
        $this->template->product = null;
        if($id){
            $this->template->product = $this->productManager->getProduct($id);
        }
    }

    public function renderList()
    {
        $this->template->products = $this->productManager->getProducts();
    }
    
    public function createComponentProductEditorForm()
    {
        return $this->formFactory->createProductForm();
    }
}