<?php

namespace System\Request\Traits;


use System\Database\DBConnection\DBConnection;

trait HasValidationRules
{
    public function normalValidation($name, $ruleArray)
    {
        foreach ($ruleArray as $rule) {
            if ($rule == "required")
                $this->required($name);
            elseif (strpos($rule, "max:") === 0) {
                $rule = str_replace("max:", "", $rule);
                $this->maxStr($name, $rule);
            } elseif (strpos($rule, "min:") === 0) {
                $rule = str_replace("min:", "", $rule);
                $this->minStr($name, $rule);
            } elseif (strpos($rule, "exists:") === 0) {
                $rule = str_replace("exists:", "", $rule);
                $rule = explode(",", $rule);
                $key = isset($rule[1]) == false ? null : $rule[1];
                $this->existsIn($name, $rule);
            } elseif ($rule == "email") {
                $this->email($name);
            } elseif ($rule == "date") {
                $this->date($name);
            }
        }
    }
    public function numberValidation($name, $ruleArray)
    {
        foreach ($ruleArray as $rule) {
            if ($rule == "required")
                $this->required($name);
            elseif (strpos($rule, "max:") === 0) {
                $rule = str_replace("max:", "", $rule);
                $this->maxNumber($name, $rule);
            } elseif (strpos($rule, "min:") === 0) {
                $rule = str_replace("min:", "", $rule);
                $this->minNumber($name, $rule);
            } elseif (strpos($rule, "exists:") === 0) {
                $rule = str_replace("exists:", "", $rule);
                $rule = explode(",", $rule);
                $key = isset($rule[1]) == false ? null : $rule[1];
                $this->existsIn($name, $rule);
            } elseif ($rule == "number") {
                $this->number($name);
            }
        }
    }

    protected function maxStr($name, $count)
    {
        if ($this->checkFieldExist($name)) {
            if (strlen($this->request[$name]) >= $count && $this->checkFirstError($name)) {
                $this->setError($name, "max length equal or lower than $count character");
            }
            $this->errorExist = true;
        }
    }
    protected function minStr($name, $count)
    {
        if ($this->checkFieldExist($name)) {
            if (strlen($this->request[$name]) <= $count && $this->checkFirstError($name)) {
                $this->setError($name, "min length equal or upper than $count character");
            }
            $this->errorExist = true;
        }
    }
    protected function maxNumber($name, $count)
    {
        if ($this->checkFieldExist($name)) {
            if ($this->request[$name] >= $count && $this->checkFirstError($name)) {
                $this->setError($name, "max number equal or lower than $count");
            }
            $this->errorExist = true;
        }
    }
    protected function minNumber($name, $count)
    {
        if ($this->checkFieldExist($name)) {
            if ($this->request[$name] <= $count && $this->checkFirstError($name)) {
                $this->setError($name, "min number equal or upper than $count");
            }
            $this->errorExist = true;
        }
    }


    protected function checkFieldExist($name)
    {
        return isset($this->$name);
    }
}
