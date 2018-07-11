<?php
/**
 * Created by PhpStorm.
 * User: olangr
 * Date: 7/11/18
 * Time: 10:29 PM
 */

namespace App\CoreModule\Presenters;

use App\Presenters\BasePresenter;
use Markette\GopayInline\Api\Entity\PaymentFactory;
use Markette\GopayInline\Api\Lists\Currency;
use Markette\GopayInline\Api\Lists\Language;
use Markette\GopayInline\Api\Lists\PaymentInstrument;
use Markette\GopayInline\Api\Lists\SwiftCode;
use Markette\GopayInline\Client;
use Markette\GopayInline\Config;

class PaymentPresenter extends BasePresenter
{
    private $goId;
    private $clientId;
    private $clientSecret;
    /** @var Client */
    private $client;

    public function __construct()
    {
        parent::__construct();
    }
}