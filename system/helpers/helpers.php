<?php

function dd($value, $die = true)
{
    echo '<pre>';
    print_r($value);
    if ($die) {
        exit;
    }
}

function view($dir, $vars = [])
{
    $viewBuilder = new \System\View\ViewBuilder();
    $viewBuilder->run($dir);
    $viewVars = $viewBuilder->vars;
    $content = $viewBuilder->content;
    empty($viewVars) ?: extract($viewVars);
    empty($vars) ?: extract($vars);
    eval(" ?>" . html_entity_decode($content));
}

function html($text)
{
    return html_entity_decode($text);
}

function old($name)
{
    if (isset($_SESSION['temporary_old'][$name])) {
        return $_SESSION['temporary_old'][$name];
    } else {
        return null;
    }
}

function flash($name, $message = null)
{
    if (empty($message)) {
        if (isset($_SESSION['temporary_flash'][$name])) {
            $temporary = $_SESSION['temporary_flash'][$name];
            unset($_SESSION['temporary_flash'][$name]);
            return $temporary;
        } else {
            return false;
        }
    } else {
        $_SESSION['flash'][$name] = $message;
    }
}


function flashExists($name)
{
    return isset($_SESSION['temporary_flash'][$name]) === true ? true : false;
}

function allFlashes()
{
    if (empty($message)) {
        if (isset($_SESSION['temporary_flash'])) {
            $temporary = $_SESSION['temporary_flash'];
            unset($_SESSION['temporary_flash']);
            return $temporary;
        } else {
            return false;
        }
    }
}

function error($name, $message = null)
{
    if (empty($message)) {
        if (isset($_SESSION['temporary_errorFlash'][$name])) {
            $temporary = $_SESSION['temporary_errorFlash'][$name];
            unset($_SESSION['temporary_errorFlash'][$name]);
            return $temporary;
        } else {
            return false;
        }
    } else {
        $_SESSION['errorFlash'][$name] = $message;
    }
}


function errorExists($name)
{
    return isset($_SESSION['temporary_errorFlash'][$name]) === true ? true : false;
}

function allErrors()
{
    if (empty($message)) {
        if (isset($_SESSION['temporary_errorFlash'])) {
            $temporary = $_SESSION['temporary_errorFlash'];
            unset($_SESSION['temporary_errorFlash']);
            return $temporary;
        } else {
            return false;
        }
    }
}

function currentDomain()
{
    $httpsProtocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
    $currentUrl = $_SERVER['HTTP_HOST'];
    return $httpsProtocol . $currentUrl;
}

function redirect($url)
{
    $url = trim($url, '/ ');
    $url = strpos($url, currentDomain()) === 0 ? $url : currentDomain() . "/" . $url;
    header("Location: " . $url);
    exit;
}

function back()
{
    $http_refere = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
    redirect($http_refere);
}

function asset($src)
{
    return currentDomain() . ("/" . trim($src, "/ "));
}

function url($url)
{
    return currentDomain() . ("/" . trim($url, "/ "));
}

function findRouteByName($name)
{
    global $routes;
    $allRoutes = array_merge($routes['get'], $routes['post'], $routes['put'], $routes['delete']);
    $route = null;
    foreach ($allRoutes as $element) {
        if ($element['name'] == $name && $element['name'] !== null) {
            $route = $element['url'];
            break;
        }
    }
    return $route;
}

function route($name, $params = [])
{
    if (!is_array($params)) {
        throw new Exception('routes params must be an array');
    }
    $route = findRouteByName($name);
    if ($route === null) {
        throw new Exception('route not found');
    }
    $params = array_reverse($params);
    $routeParamsMatch = [];
    preg_match_all('/{[^}.]*}/', $route, $routeParamsMatch);
    if (count($routeParamsMatch) > count($params)) {
        throw new Exception('route params not enough');
    }
    foreach ($routeParamsMatch[0] as $key => $routeMatch) {
        $route = str_replace($routeMatch, array_pop($params), $route);
    }
    return currentDomain() . "/" . trim($route, " /");
}
