<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 6/25/18
 * Time: 11:12 AM
 */

namespace Langriklol\Utils;

use Nette\Utils\ArrayHash;
use App\CoreModule\Model\Shop\Product;

class ProductSortHelper
{
    public function sortProductFrontEnd(array $products): ArrayHash
    {
        $productCount = [];
        $productIndexer = [];

        if($products)
        {
            foreach ($products as $product) {
                if(isset($productCount[$product->getId()]) && $productCount[$product->getId()])
                    $productCount[$product->getId()]++;
                else
                    $productCount[$product->getId()] = 1;
            }

            $productFrontend = [];

            foreach ($products as $product) {
                if(!isset($productIndexer[$product->id])) {
                    $productFrontend[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'category' => $product->category,
                        'manufacturer' => $product->manufacturer,
                        'price' => $product->price,
                        'availability' => $product->availability,
                        'image' => $product->image,
                        'count' => $productCount[$product->id]
                    ];
                    $productIndexer[$product->id] = 1;
                }
            }
            return ArrayHash::from($productFrontend);
        }
        return ArrayHash::from([]);
    }
}