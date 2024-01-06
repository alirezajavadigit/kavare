<?php

namespace System\Router;

class Routing
{
    private $current_route;
    private $method_field;
    private $routes;
    private $values;

    public function __construct()
    {
        $this->current_route = explode("/", CURRENT_ROUTE);
        $this->method_field = $this->methodField();
        global $routes;
        $this->routes = $routes;
    }

    private function methodField()
    {
        $method_field = strtolower($_SERVER['REQUEST_METHOD']);
        if ($method_field == "post") {
            if(isset($_POST['_method'])) {
                if($_POST['_method'] == "put") {
                    $method_field = "put";
                }elseif($_POST['_method'] == "delete") {
                    $method_field = "delete";
                }
            }
        }
        return $method_field;
    }
    public function run()
    {
    }
}
