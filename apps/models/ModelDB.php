<?php

namespace App\models;

use App\core\Model;

class ModelDB extends Model
{
    public function __construct($table)
    {
        parent::__construct();
        
        $this->table = $table;
    }
}
