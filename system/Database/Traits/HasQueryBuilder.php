<?php

namespace System\Database\Traits;

use System\Database\DBConnection\DBConnection;

trait HasQueryBuilder{
    private $sql = "";
    protected $where = [];
    protected $orderBy = [];
    protected $limit = [];
    protected $values = [];
    protected $bindValues = [];

    protected function setSql($query){
        $this->sql = $query;
    }
    protected function getSql(){
        return $this->sql;
    }
    protected function resetSql(){
        $this->sql = "";
    }

    
}