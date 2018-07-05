<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 5/28/18
 * Time: 8:35 PM
 */

namespace App\Forms;

use App\CoreModule\Model\Shop\Order\Order;
use App\CoreModule\Model\Shop\ProductManager;
use Nette\Application\UI\Form;

class AdministrationFormFactory
{
    /**
     * @var ProductManager $productManager
     */
    private $productManager;

    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }

    /**
     * @param $form
     * @param $values
     * @throws \Nette\Application\AbortException
     */
    public function productFormSucceeded(Form $form, $values)
    {
        $image = $values->image;
        $imagePath = './pics/product/' . $image->getName();
        $image->move($imagePath);
        $product = $this->productManager->createProduct(
            null,
            $values->name,
            $values->manufacturer,
            $values->category,
            $values->description,
            $values->price,
            $imagePath
        );
        $row = $this->productManager->saveProduct($product);
        bdump($row->toArray());
        $productId = $row->toArray()['product_id'];
        $form->getPresenter()->redirect('Product:default', ['id' => $productId]);
    }

    /**
     * @return Form
     */
    public function createProductFormBasic():Form
    {
        $form = new Form();
        $form->addText('name', 'Product name')
            ->setRequired();
        $form->addText('manufacturer', 'Manufacturer')
            ->setRequired();
        $form->addText('category', 'Category')
            ->setRequired();
        $form->addText('description', 'Description');
        $form->addText('price', 'Price')
            ->setRequired();
        return $form;
    }

    /**
     * @return Form
     */
    public function createProductForm(): Form
    {
        $form = $this->createProductFormBasic();
        $form->addUpload('image', 'Thumbnail')
            ->addCondition(Form::IMAGE)
            ->addRule(Form::MIME_TYPE, 'Product thumbnail must be JPEG or PNG', ['image/jpeg', 'image/png'])
            ->setRequired();
        $form->addSubmit('add', 'Add product');
        $form->onSuccess[] = [$this, 'productFormSucceeded'];
        return $form;
    }

    public function createNewOrderForm(): Form
    {
        $form = new Form();
        $form->addText('name', 'Order name');
        $form->addSelect('delivery', 'Delivery', [
            Order::TYPE_CASH_ON_DELIVERY => 'Cash on delivery',
            Order::TYPE_PAID => 'Payment in advance'
        ]);
        $form['country']->setDefaultValue(Order::TYPE_CASH_ON_DELIVERY);
        $form->addText('description', 'Description')
            ->addRule(Form::MAX_LENGTH, 'Description length must be less or equal 255 characters', 255);
        return $form;
    }
}