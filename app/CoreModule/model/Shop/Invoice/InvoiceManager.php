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
        bdump($this->invoice);
        return $this;
    }

    public function send()
    {
        $client = $this->findClient($this->order->user);

        $params = [
            'order' => $this->order
        ];

        $mail = new Message();
        $mail->setFrom('langrik666@gmail.com', 'EasyShop')
            ->addTo($client->email)
            ->setSubject('Order confirmation')
            ->setHtmlBody($this->makeMailBody($params));

        $mailer = new SmtpMailer();
        $mailer->send($mail);
    }

    /**
     * @throws \Mpdf\MpdfException
     */
    public function export()
    {
        $mpdf = new Mpdf([]);
        $mpdf->WriteHTML($this->html);
        $this->saveInvoice($mpdf, 'Invoice ' . $this->order->getName(). '.pdf');
        $mpdf->Output($this->order->getId(). $this->order->getName(), 'I');
    }

    /**
     * @return InvoiceManager
     */
    public function makeTemplate(): InvoiceManager
    {
        $latte = new Latte\Engine;
        $client = $this->findClient($this->order->getUser());
        //bdump($this->invoice, 'invoice');
        $params = [
            'order' => $this->invoice->getOrder(),
            'client' => $client
        ];
        //bdump( __DIR__);
        $this->html = $latte->renderToString(__DIR__ .'/../../../templates/Invoice/invoice.latte', $params);
        return $this;
    }

    /**
     * @param Mpdf $mpdf
     * @throws \Mpdf\MpdfException
     */
    private function saveInvoice(Mpdf $mpdf, $fileName)
    {
        $mpdf->Output(__DIR__ . '/../../../../../www/Invoices/' . $fileName, 'F');
    }

    private function makeMailBody(array $params = null)
    {
        $latte = new Latte\Engine;
        return $latte->renderToString(__DIR__ .'/../../../templates/Invoice/email.latte', $params);
    }
}