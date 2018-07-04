<?php

namespace App\CoreModule\Model\Shop;
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
        COLUMN_ID = 'product_id';

    /**
     * @return array|IRow[] products
     */
    public function getProducts()
    {
        $products = [];
        $dbProducts = $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
        foreach ($dbProducts as $dbProduct)
        {
            $products[] = $this->factory->createProduct(
                $dbProduct->product_id,
                $dbProduct->name,
                $dbProduct->manufacturer,
                $dbProduct->category,
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
            $id,
            $meta->name,
            $meta->manufacturer,
            $meta->category,
            $meta->price,
            $meta->description,
            $meta->image,
            $meta->availability
        );
    }

    /**
     * @param $product Product product
     * @return ActiveRow|int Returns ActiveRow or number of affected rows
     */
    public function saveProduct(Product $product)
    {
        $product = $product->toArrayHash();
        // How to save one DB query? Check if product have product id, then it is not new
        if(!$product[self::COLUMN_ID])
            return $this->db->table(self::TABLE_NAME)->insert($product);
        else
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $product[self::COLUMN_ID])->update($product);
    }

    /**
     * @param int|null $id
     * @param string $name
     * @param string $manufacturer
     * @param string $category
     * @param string $description
     * @param float $price
     * @param string $image
     * @param string $availability
     * @return Product
     */
    public function createProduct(?int $id = null, string $name, string $manufacturer, string $category, string $description, float $price, string $image, string $availability = Product::AVAILABLE)
    {
        return $this->factory->createProduct($id, $name, $manufacturer, $category, $price, $description, $image, $availability);
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