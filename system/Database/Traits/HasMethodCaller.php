<?php

namespace System\Database\Traits;

trait HasMethodCaller{
    private $allMethod = ['create', 'update', 'delete', 'find', 'all', 'where', 'whereOr', 'save', 'whereIn', 'whereNull', 'whereNotNull', 'orderBy', 'get', 'limit', 'paginate'];
    private $allowedMethod = ['create', 'update', 'delete', 'find', 'all', 'where', 'whereOr', 'save', 'whereIn', 'whereNull', 'whereNotNull', 'orderBy', 'get', 'limit', 'paginate'];
    protected function setAllowedMethods($array){
        $this->allowedMethod = $array;
    }
}