<?php
/**
 * Created by PhpStorm.
 * User: olangr
 * Date: 7/14/18
 * Time: 9:12 PM
 */

namespace App\CoreModule\Model\Shop;


use Nette\Security\Identity;

class Payment
{
    /** @var Identity */
    private $identity;

    public function __construct(Identity $identity)
    {
        $this->identity = $identity;
    }
}