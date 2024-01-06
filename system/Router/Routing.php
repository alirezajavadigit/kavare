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
    public function run()
    {
    }
    public function match()
    {
        $reservedRoutes = $this->routes[$this->methodField()];
        foreach ($reservedRoutes as $reservedRoute) {
            if($this->compare($reservedRoute['url'] == true)){
                return ["class" => $reservedRoute['class'], "method" => $reservedRoute['method']];
            }else{
                $this->values = [];
            }
        }
        return [];
    }

    private function compare($reservedRouteUrl){
        // part 1
        if(trim($reservedRouteUrl, "/") === ""){
            return trim($this->current_route[0], "/") === "" ? true : false;
        }

        // part 2
        $reservedRouteUrlArray = explode("/", $reservedRouteUrl);
        if(sizeof($this->current_route) != sizeof($reservedRouteUrlArray)){
            return false;
        }

        // part 3
        foreach($this->current_route as $key =>$currentRouteElement){
            $reservedRouteUrlElement = $reservedRouteUrlArray[$key];
            if(substr($reservedRouteUrlElement, 0, 1) == "{" && substr($reservedRouteUrlElement, -1) == "}"){
                array_push($this->values, $currentRouteElement);
            }
            elseif($reservedRouteUrlElement != $currentRouteElement){
                return false;
            }
        }
        return true;
    }

    public function error404(){
        http_response_code(404);
        include __DIR__ . DIRECTORY_SEPARATOR . "View" . DIRECTORY_SEPARATOR . "404.php";
        exit;
    }

    public function methodField()
    {
        $method_field = strtolower($_SERVER['REQUEST_METHOD']);
        if ($method_field == "post") {
            if (isset($_POST['_method'])) {
                if ($_POST['_method'] == "put") {
                    $method_field = "put";
                } elseif ($_POST['_method'] == "delete") {
                    $method_field = "delete";
                }
            }
        }
        return $method_field;
    }
}
