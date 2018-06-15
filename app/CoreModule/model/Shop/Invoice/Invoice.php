<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 6/15/18
 * Time: 5:30 PM
 */

namespace App\CoreModule\Model\Shop\Invoice;

use App\CoreModule\Model\Shop\Product;

class Invoice
{
    /**
     * @var Product[] $products
     */
    private $products;
    /** @var string $createdAt Date of created invoice */
    private $createdAt;
    /** @var string */
    private $clientAddress;

    private $clientName;

    private $clientCity;
}