<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 6/16/18
 * Time: 11:14 PM
 */

namespace App\CoreModule\model\Shop\Invoice;

use Mpdf\Mpdf;
use Nette;
use Latte;

class InvoiceManager
{
    /** @var  */
    private $pdfCreator;
    /** @var Invoice */
    private $invoice;

    public function __construct(Mpdf $mpdf)
    {
        $this->pdfCreator = $mpdf;
    }

    public function send()
    {
        
    }

    public function export()
    {

    }

    public function makeTemplate()
    {
        $latte = new Latte\Engine;
        $template = new \Nette\Bridges\ApplicationLatte\TemplateFactory($latte);
        
    }
}