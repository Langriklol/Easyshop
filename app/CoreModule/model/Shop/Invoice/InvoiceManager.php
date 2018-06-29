<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 6/16/18
 * Time: 11:14 PM
 */

namespace App\CoreModule\model\Shop\Invoice;

use App\CoreModule\Model\Shop\Order\Order;
use App\Model\BaseManager;
use Mpdf\Mpdf;
use Nette;
use Latte;
use Nette\Database\Context;
use Nette\Mail\SmtpMailer;
use Nette\Mail\Message;
use Nette\Utils\ArrayHash;

class InvoiceManager extends BaseManager
{
    /** @var Invoice $invoice */
    private $invoice;
    /** @var Order $order */
    private $order;
    /** @var string $html */
    private $html;

    /**
     * InvoiceManager constructor.
     * @param Context $context
     * @param Order $order
     */
    public function __construct(Context $context, Order $order)
    {
        parent::__construct($context);
        $this->order = $order;
    }

    private function findClient(int $id)
    {
        $credits = $this->db->table('user')
            ->select('email, name, residence, phone, ico')
            ->where('user_id', $id)
            ->fetch();
        return ArrayHash::from($credits->toArray());
    }

    /** Makes invoice
     * @return InvoiceManager
     */
    public function makeInvoice(): InvoiceManager
    {
        $this->invoice = new Invoice($this->order, $this->findClient($this->order->user));
        return $this;
    }

    public function send()
    {
        
    }

    /**
     * @throws \Mpdf\MpdfException
     */
    public function export()
    {
        $mpdf = new Mpdf([]);
        $mpdf->WriteHTML($this->html);
        $mpdf->Output($this->order->getId(). $this->order->getName(), 'I');
    }

    /**
     * @return InvoiceManager
     */
    public function makeTemplate(): InvoiceManager
    {
        $latte = new Latte\Engine;
        $client = $this->findClient($this->order->getUser());
        $params = [
            'order' => $this->invoice->getOrder(),
            'client' => $client
        ];
        $this->html = $latte->renderToString('../../../templates/Invoice/invoice.latte', $params);
        return $this;
    }
}