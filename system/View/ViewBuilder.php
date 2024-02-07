<?php

namespace System\View;

use System\View\Traits\HasViewLoader;
use System\View\Traits\HasExtendsContent;
use System\View\Traits\HasIncludeContent;

class ViewBuilder
{
    use HasViewLoader, HasExtendsContent, HasIncludeContent;

    public $content;

    public function run($dir)
    {
        $this->content = $this->viewLoader($dir);
        $this->checkExtendsContent();
        $this->checkIncludesContent();
    }
}
