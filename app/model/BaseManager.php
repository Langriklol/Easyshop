<?php
namespace App\Model;

use Nette\Database\Context;
use Nette\Object;

abstract class BaseManager extends Object
{
    /** @var Context db context for db handling */
    protected $db;

    public function __construct(Context $database)
    {
        $this->db = $database;
    }
}