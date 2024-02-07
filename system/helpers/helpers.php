<?php

function view($dir, $vars = []){
    $viewBuilder = new \System\View\ViewBuilder();
    $viewBuilder->run($dir);
    $viewVars = $viewBuilder->vars;
    $content = $viewBuilder->content;
    empty($viewVars) ? : extract($viewVars);
    empty($vars) ? : extract($vars);
    eval(" ?>" . html_entity_decode($content));
}