<?php

namespace System\Request\Traits;


trait HasFileValidationRules
{

    protected function fileValidation($name, $ruleArray)
    {
        foreach ($ruleArray as $rule) {
            if ($rule == "required") {
                $this->fileRequired($name);
            } elseif (strpos($rule, "mimes:") === 0) {
                $rule = str_replace('mimes:', "", $rule);
                $rule = explode(',', $rule);
                $this->fileType($name, $rule);
            } elseif (strpos($rule, "max:") === 0) {
                $rule = str_replace('max:', "", $rule);
                $this->maxFile($name, $rule);
            } elseif (strpos($rule, "min:") === 0) {
                $rule = str_replace('min:', "", $rule);
                $this->minFile($name, $rule);
            }
        }
    }

    protected function fileRequired($name)
    {
        if (!isset($this->files[$name]['name']) || empty($this->files[$name]['name'])  && $this->checkFieldExist($name)) {
            $this->setError($name, "$name is required");
        }
    }

    protected function fileType($name, $typesArray)
    {
        if ($this->checkFirstError($name) && $this->checkFieldExist($name)) {
            $currentFileType = explode('/', $this->files[$name]['type'])[1];
            if (!in_array($currentFileType, $typesArray)) {
                $this->setError($name, "$name type must be " . implode(',', $typesArray));
            }
        }
    }

    protected function maxFile($name, $size)
    {
        $currentFileSize = $this->files[$name]['size'];
        $size = $size * 1024;
        if (!isset($this->files[$name]['name']) || empty($this->files[$name]['name'])  && $this->checkFieldExist($name)) {
            if ($currentFileSize > $size) {
                $this->setError($name, "$name size must be lower than " . ($size / 1024));
            }
        }
    }
    protected function minFile($name, $size)
    {
        $currentFileSize = $this->files[$name]['size'];
        $size = $size * 1024;
        if (!isset($this->files[$name]['name']) || empty($this->files[$name]['name'])  && $this->checkFieldExist($name)) {
            if ($currentFileSize < $size) {
                $this->setError($name, "$name size must be upper than " . ($size / 1024));
            }
        }
    }
}
