<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 5/28/18
 * Time: 8:35 PM
 */

namespace App\Forms;

use App\CoreModule\Model\ProductManager;
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
     */
    public function productFormSucceeded($form, $values)
    {
        $image = $values->image;
        $imagePath = './pics/product/' . $image->getName();
        $image->move($imagePath);
        $product = $this->productManager->createProduct(
            $values->product_id,
            $values->name,
            $values->description,
            $values->price,
            $imagePath
        );
        $this->productManager->saveProduct($product);
    }

    public function createProductFormBasic():Form
    {
        $form = new Form();
        $form->addInteger('product_id', 'Product id')
            ->setRequired();
        $form->addText('name', 'Product name')
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
}