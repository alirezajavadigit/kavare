<?php

namespace System\Application;

class Application
{
    public function __construct()
    {
        $this->loadProivders();
        $this->loadHelpers();
        $this->registerRoute();
        $this->routing();
    }

    private function loadProivders()
    {
        $appConfigs = require dirname(dirname(__DIR__)) . "/config/app.php";
        $providers = $appConfigs['providers'];
        foreach ($providers as $provider) {
            $providerObject = new $provider();
            $providerObject->boot();
        }
    }
    private function loadHelpers()
    {
        require_once(dirname(__DIR__) . "/helpers/helpers.php");
        if (file_exists(dirname(dirname(__DIR__)) . "/app/Http/Helpers.php")) {
            require_once(dirname(dirname(__DIR__)) . "/app/Http/Helpers.php");
        }
    }
    private function registerRoute()
    {

        global $routes;
        $routes = ['get' => [], 'post' => [], 'put' => [], 'delete' => []];

        require_once(dirname(dirname(__DIR__)) . "/routes/web.php");
        require_once(dirname(dirname(__DIR__)) . "/routes/api.php");
    }
    private function routing()
    {
        $routing = new \System\Router\Routing();
        $routing->run();
    }
}
