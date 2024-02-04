<?php

namespace System\Request;


use System\Request\Traits\HasFileValidationRules;
use System\Request\Traits\HasRunValidation;
use System\Request\Traits\HasValidationRules;

class Request
{
    use HasValidationRules,HasFileValidationRules,HasRunValidation;

    protected $errorExist = false;
    protected $request;
    protected $files = null;
    protected $errorVariablesName = [];

    public function __construct()
    {
        if(isset($_POST)) {
            $this->postAttributes();
        }
        if(!empty($_FILES))
            $this->files = $_FILES;
        $rules = $this->rules();
        empty($rules) ? : $this->run($rules);
        $this->errorRedirect();
    }


    protected function rules()
    {
        return [];
    }

    protected function run($rules){
        foreach($rules as $att => $values){
            $ruleArray = explode('|', $values);
            if(in_array('file', $ruleArray))
            {
                unset($ruleArray[array_search('file', $ruleArray)]);
                $this->fileValidation($att, $ruleArray);
            }
            elseif(in_array('number', $ruleArray))
            {
                $this->numberValidation($att, $ruleArray);
            }
            else
            {
                $this->normalValidation($att, $ruleArray);
            }
        }
    }

    public function file($name){
        return isset($this->files[$name]) ? $this->files[$name] : false;
    }

    protected function postAttributes()
    {
        foreach($_POST as $key => $value){
            $this->$key = htmlentities($value);
            $this->request[$key] = htmlentities($value);
        }
    }

    public function all(){
       return $this->request;
    }


}