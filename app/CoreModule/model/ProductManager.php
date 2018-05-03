<?php

namespace App\CoreModule\Model;
use App\Model\BaseManager;
use Nette\Database\Table\IRow;
use Nette\Database\Table\ActiveRow;
use Nette\Utils\ArrayHash;

class ProductManager extends BaseManager
{
    const TABLE_NAME = 'product',
        COLUMN_ID = 'product_id';

    /**
     * @return array|IRow[] products
     */
    public function getProducts()
    {
        return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID . 'DESC')->fetchAll();
    }

    /**
     * @param int $id
     * @return false|\Nette\Database\Table\ActiveRow
     */
    public function getProduct(int $id)
    {
        return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
    }

    /**
     * @param $product array|ArrayHash product
     */
    public function saveProduct($product)
    {
        // How to save one DB query? Check if product have product id, then it is not new
        if(!$product[self::COLUMN_ID])
            $this->db->table(self::TABLE_NAME)->insert($product);
        else
            $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $product[self::COLUMN_ID])->update($product);
    }

    /**
     * @param $product
     */
    public function deleteProduct($product)
    {
        $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $product[self::COLUMN_ID])->delete();
    }
}