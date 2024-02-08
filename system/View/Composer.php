<?php


namespace System\View;

class Composer
{
    private static $instance;
    private $vars = [];
    private $viewArray = [];

    private function __construct()
    {
    }

    public static function __callStatic($name, $arguments)
    {
        $instance = self::getInstance();
        switch ($name) {
            case 'view':
                return call_user_func_array(array($instance, "registerView"), $arguments);
                break;
            case 'setViews':
                return call_user_func_array(array($instance, "setViewArray"), $arguments);
                break;
            case 'getVars':
                return call_user_func_array(array($instance, "getViewVars"), $arguments);
                break;
        }
    }

    private function registerView($name, $callback)
    {
        if (in_array(str_replace(".", "/", $name), $this->viewArray) || $name == "*") {
            $viewVars = $callback();
            foreach ($viewVars as $key => $value) {
                $this->vars[$key] = $value;
            }
            if (isset($this->viewArray[$name])) {
                unset($this->viewArray[$name]);
            }
        }
    }

    private function setViewArray($viewArray)
    {
        $this->viewArray = $viewArray;
    }

    private function getViewVars()
    {
        return $this->vars;
    }

    private static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}
