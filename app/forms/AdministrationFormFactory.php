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
        if($values->product_image->isImage() && $values->product_image->isOk())
        {
            $image = $values->product_image;
            $image_name = $image->getSanitizedName();
        }
        $product = $this->productManager->createProduct(
            $values->product_id,
            $values->product_name,
            $values->product_description,
            $values->product_price,
            $values->product_image
        );
    }

    /**
     * @return Form
     */
    public function createBasicForm(): Form
    {
        $form = new Form();
        $form->addInteger('product_id', 'Product id')
            ->setRequired();
        $form->addText('product_name', 'Product name')
            ->setRequired();
        $form->addText('product_description', 'Description');
        $form->addText('product_price', 'Price')
            ->setRequired();
        $form->addUpload('product_image', 'Thumbnail')
            ->addCondition(Form::IMAGE)
            ->addRule(Form::MIME_TYPE, 'Product thumbnail must be JPEG or PNG', ['image/jpeg', 'image/png']);
        $form->addSubmit('product_add', 'Add product');
        $form->onSuccess[] = [$this, 'productFormSucceeded'];

        return $form;
    }
}