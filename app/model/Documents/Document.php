<?php
/**
 * Created by PhpStorm.
 * User: lango
 * Date: 6/26/18
 * Time: 9:22 AM
 */

namespace app\model\Documents;

use Mpdf\Mpdf;

class Document
{
    const TYPE_PDF = 'pdf';

    const ORIENTATION_LANDSCAPE = 'landscape',
        ORIENTATION_PORTRAIT = 'portrait';

    const SIZE_A0 = 'a0',
        SIZE_A1 = 'a1',
        SIZE_A2 = 'a2',
        SIZE_A3 = 'a3',
        SIZE_A4 = 'a4',
        SIZE_A5 = 'a5';

    /**
     * @var Mpdf
     */
    private $mPDF;

    public function __construct()
    {

    }
}