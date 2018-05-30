<?php

namespace App\CoreModule\Model;
use App\CoreModule\Model\Shop\Product;
use App\CoreModule\Model\Shop\ProductFactory;
use App\Model\BaseManager;
use Nette\Database\Context;
use Nette\Database\Table\IRow;
use Nette\Database\Table\ActiveRow;

class ProductManager extends BaseManager
{
    /**
     * @var ProductFactory $factory
     */
    private $factory;

    public function __construct(Context $context, ProductFactory $factory)
    {
        parent::__construct($context);
        $this->factory = $factory;
    }

    const TABLE_NAME = 'product',
        COLUMN_ID = 'id';

    /**
     * @return array|IRow[] products
     */
    public function getProducts()
    {
        $products = [];
        $dbProducts = $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID . 'DESC')->fetchAll();
        foreach ($dbProducts as $dbProduct)
        {
            $products[] = $this->factory->createProduct(
                $dbProduct->id,
                $dbProduct->name,
                $dbProduct->price,
                $dbProduct->description,
                $dbProduct->image,
                $dbProduct->availability
            );
        }
        return $products;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function getProduct(int $id)
    {
        $meta = $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
        return $this->factory->createProduct(
            $meta->id,
            $meta->name,
            $meta->price,
            $meta->description,
            $meta->image,
            $meta->availability
        );
    }

    /**
     * @param $product Product product
     */
    public function saveProduct(Product $product)
    {
        $product = $product->toArrayHash();
        // How to save one DB query? Check if product have product id, then it is not new
        if(!$product[self::COLUMN_ID])
            $this->db->table(self::TABLE_NAME)->insert($product);
        else
            $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $product[self::COLUMN_ID])->update($product);
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $description
     * @param float $price
     * @param string $image
     * @param int $availability
     * @return Product
     */
    public function createProduct(int $id, string $name, string $description, float $price, string $image, int $availability = Product::AVAILABLE)
    {
        return $this->factory->createProduct($id, $name, $price, $description, $image, $availability);
    }

    /**
     * @param Product $product
     */
    public function deleteProduct(Product $product)
    {
        $product = $product->toArrayHash();
        $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $product[self::COLUMN_ID])->delete();
    }
}