<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 6/15/18
 * Time: 5:30 PM
 */

namespace App\CoreModule\Model\Shop\Invoice;

use App\CoreModule\Model\Shop\Order\Order;
use Nette\Utils\ArrayHash;
use Nette;

/**
 * Class Invoice
 * @package App\CoreModule\Model\Shop\Invoice
 * @param Order $order
 * @param ArrayHash $client
 */
class Invoice
{
    use Nette\SmartObject;
    /**
     * @var Order $order
     */
    private $order;

    /**
     * @var ArrayHash $client info
     */
    private $client;

    /**
     * Invoice constructor.
     * @param ArrayHash $client
     * @param Order $order
     */
    public function __construct(Order $order, ArrayHash $client)
    {
        $this->client = $client;
        $this->order = $order;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * Fluent setter
     * @param Order $order
     * @return Invoice
     */
    public function setOrder(Order $order): Invoice
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return ArrayHash
     */
    public function getClient(): ArrayHash
    {
        return $this->client;
    }

    /**
     * @param ArrayHash $client
     * @return Invoice
     */
    public function setClient(ArrayHash $client): Invoice
    {
        $this->client = $client;
        return $this;
    }
}