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
