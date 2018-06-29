<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 6/27/18
 * Time: 12:46 PM
 */

namespace App\CoreModule\Presenters;

use App\CoreModule\model\Shop\Invoice\InvoiceManager;
use App\CoreModule\Model\Shop\Order\OrderManager;
use App\Presenters\BasePresenter;
use Nette\Database\Context;

/**
 * Class InvoicePresenter
 * @package App\CoreModule\Presenters
 */
class InvoicePresenter extends BasePresenter
{
    /** @var InvoiceManager */
    private $invoiceManager;
    private $orderManager;
    private $db;

    public function __construct(Context $context, OrderManager $orderManager)
    {
        parent::__construct();
        $this->db = $context;
        $this->orderManager = $orderManager;
    }

    public function actionMake()
    {
        
    }

    /**
     * @param int $id
     * @throws \Mpdf\MpdfException
     */
    public function renderDefault(int $id)
    {
        $order = $this->orderManager->getOrder($id);
        $invoiceManager = new InvoiceManager($this->db, $order);
        $invoiceManager->makeTemplate()->makeInvoice()->export();
    }
}