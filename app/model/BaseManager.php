<?php
namespace App\Model;

use Nette\Database\Context;

abstract class BaseManager
{
    use \Nette\SmartObject;

    /** @var Context db context for db handling */
    protected $db;

    public function __construct(Context $database)
    {
        $this->db = $database;
    }
}