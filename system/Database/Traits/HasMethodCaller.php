<?php

namespace System\Database\Traits;

trait HasMethodCaller
{
    private $allMethods = ['create', 'update', 'delete', 'find', 'all', 'where', 'whereOr', 'save', 'whereIn', 'whereNull', 'whereNotNull', 'orderBy', 'get', 'limit', 'paginate'];
    private $allowedMethod = ['create', 'update', 'delete', 'find', 'all', 'where', 'whereOr', 'save', 'whereIn', 'whereNull', 'whereNotNull', 'orderBy', 'get', 'limit', 'paginate'];

    public function __call($method, $args)
    {
        return $this->methodCaller($this, $method, $args);
    }

    public function callStatic($method, $args)
    {
        $className = get_called_class();
        $instance = new $className;
        return $this->methodCaller($instance, $method, $args);
    }

    protected function setAllowedMethods($array)
    {
        $this->allowedMethod = $array;
    }

    private function methodCaller($object, $method, $args)
    {
        $suffix = "Method";
        $methodName = $method . $suffix;
        if (in_array($methodName, $this->allowedMethod)) {
            return call_user_func_array(array($object, $methodName), $args);
        }
    }
}
